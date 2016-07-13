<?php

namespace App\Clusters\RevisionerCluster\Controllers;

use App\Clusters\RevisionerCluster\Models\Revision;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class RevisionsController extends RevisionerClusterController
{

    public function index()
    {
        $revisions = Revision::with('user')->orderBy('created_at')->get();
        $revisions = $revisions->groupBy('model');

        return $this->view('revisions.index', compact('revisions'));
    }

    public function show( $id )
    {
        $revision = Revision::with('user')->findOrFail($id);

        return $this->view('revisions.show', compact('revision'));
    }

    public function update( $id, Request $request )
    {
        $revision = Revision::findOrFail($id);
        $model = $revision->model;

        if ( $revision->revised ) {
            Flash::error( 'Revision is already revised!' );

            return redirect()->back();
        }

        // Reject this revision otherwise proceed with Approve
        if ( $request->input('action') == 'Reject' ) {
            $revision->update([ 'revised' => true ]);

            Flash::success( 'Revision for model '. $model .' successfully rejected.' );

            return redirect()->back();
        }

        $model::flushEventListeners();// disable events for the model so create/update can run

        // Update existing record
        if ( $revision->item_id ) {
            $record = $model::findOrFail( $revision->item_id );

            if ( $record->update( $revision->after ) ) {
                Flash::success( 'Model '. $model .' updated successfully.' );
                $revision->update([ 'revised' => true, 'approved' => true ]);
            } else {
                Flash::errror( 'There was an error updating model '. $model .' !' );
            }

            return redirect()->back();
        }

        // Create new record
        if ( $model::create( $revision->before ) ) {
            Flash::success( 'Model '. $model .' created successfully.' );
            $revision->update([ 'revised' => true, 'approved' => true ]);
        } else {
            Flash::errror( 'There was an error creating model '. $model .' !' );
        }

        return redirect()->back();
    }

    public function destroy( $id )
    {
        $revision = Revision::findOrFail($id);

        $revision->delete();

        Flash::success( 'Revision deleted successfully.' );

        return redirect()->back();
    }
}

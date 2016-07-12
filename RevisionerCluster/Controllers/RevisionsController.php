<?php

namespace App\Clusters\RevisionerCluster\Controllers;

use App\Clusters\RevisionerCluster\Models\Revision;
use Laracasts\Flash\Flash;

class RevisionsController extends RevisionerClusterController
{

    public function index()
    {
        $revisions = Revision::with('user')->orderBy('item_id')->get();
        $revisions = $revisions->groupBy('model');

        return $this->view('revisions.index', compact('revisions'));
    }

    public function show( $id )
    {
        $revision = Revision::with('user')->findOrFail($id);

        return $this->view('revisions.show', compact('revision'));
    }

    public function update()
    {
        // Update revision and model record if approved
        //TODO check if already revised do not update
    }

    public function destroy( $id )
    {
        $revision = Revision::findOrFail($id);

        $revision->delete();

        Flash::success( 'Revision deleted successfully.' );

        return redirect()->back();
    }
}

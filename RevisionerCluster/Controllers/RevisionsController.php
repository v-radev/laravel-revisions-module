<?php

namespace App\Clusters\RevisionerCluster\Controllers;

use App\Clusters\RevisionerCluster\Models\Revision;

class RevisionsController extends RevisionerClusterController
{

    //TODO once revised there should be no option to approve or reject

    public function index()
    {
        $revisions = Revision::with('user')->get();
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
    }

    public function destroy()
    {
        // Delete revision
    }
}

<?php

namespace App\Clusters\RevisionerCluster\Controllers;

use App\Clusters\RevisionerCluster\Models\Revision;

class RevisionsController extends RevisionerClusterController
{
    public function index()
    {
        $revisions = Revision::with('user')->get();
        $revisions = $revisions->groupBy('model');

        return $this->view('revisions.index', compact('revisions'));
    }

    public function show()
    {
        // Show revision by ID
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

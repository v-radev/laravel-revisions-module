<?php

use App\Clusters\AuthCluster\Models\User;
use Codeception\Actor;

class RevisionerClusterFunctionalityCest
{

    protected $revisionsListURL = '/dashboard/revisions';

    protected $createItemURL = '/dashboard/posts/create';

    protected $itemListURL = '/dashboard/posts';

    protected $itemTableName = 'posts';

    protected $revisionTableName = 'revisions';

    /**
     * @var User
     */
    protected $user = null;


    public function it_saves_new_items_in_revisions_table( AcceptanceTester $I )
    {
        $slug = 'test-post-1';

        // world
        $this->user = factory(User::class)->create();
        $this->user->setRoleAdmin();
        $I->amLoggedAs($this->user);
        $I->amOnPage( $this->createItemURL );

        // action
        $this->createItem( $I, $slug );

        // assert
        $I->dontSeeRecord($this->itemTableName, ['slug' => $slug]); // item should not be created in his real table
        $I->seeRecord($this->revisionTableName, ['user_id' => $this->user->id]); // a revision for this item should be created instead
    }

    public function it_doesnt_save_items_in_items_table_after_rejected( AcceptanceTester $I )
    {
        $slug = 'test-post-1';

        // world
        $this->user = factory(User::class)->create();
        $this->user->setRoleAdmin();
        $I->amLoggedAs($this->user);
        $I->amOnPage( $this->createItemURL );
        // create item
        $this->createItem( $I, $slug );
        $revision = $I->grabRecord($this->revisionTableName, ['user_id' => $this->user->id]);
        $I->amOnPage( $this->revisionsListURL . '/' . $revision['id'] );

        // assert
        $I->see('Not yet revised');
        $I->see('not approved');

        // action
        $I->click('Reject');

        // assert
        $I->see('Already revised');
        $I->see('not approved');
        $I->see('successfully rejected.');
        $I->dontSeeRecord($this->itemTableName, ['slug' => $slug]); // item is rejected so not updated in DB
    }

    public function it_saves_items_in_items_table_after_approved( AcceptanceTester $I )
    {
        $slug = 'test-post-1';

        // world
        $this->user = factory(User::class)->create();
        $this->user->setRoleAdmin();
        $I->amLoggedAs($this->user);

        // action + assert
        $this->approveItem($I, $slug);
    }

    public function it_successfully_makes_item_updates( AcceptanceTester $I )
    {
        $slug = 'test-post-1';
        $newSlug = 'test-post-1-edited';

        // world
        $this->user = factory(User::class)->create();
        $this->user->setRoleAdmin();
        $I->amLoggedAs($this->user);
        // create approved item
        $this->approveItem($I, $slug);
        $item = $I->grabRecord($this->itemTableName, ['slug' => $slug]);
        $I->amOnPage( $this->itemListURL . '/' . $item['id'] . '/edit' );

        // action
        $I->fillField('slug', $newSlug); // update slug
        $I->click('Save');

        // assert
        $I->see('updated successfully');

        $revision = $I->grabRecord($this->revisionTableName, ['item_id' => $item['id']]);

        // assert
        $I->assertTrue( count( json_decode($revision['before'], true) ) == 1 ); // number of updated columns should be 1

        // go to revision page for this slug update
        $I->amOnPage( $this->revisionsListURL . '/' . $revision['id'] );

        // assert
        $I->see('Not yet revised');
        $I->see('not approved');

        // action
        $I->click('Approve');

        // assert
        $I->see('Already revised');
        $I->see('approved');
        $I->see('updated successfully');
        $I->seeRecord($this->itemTableName, ['slug' => $newSlug]); // item slug should be updated
        $I->dontSeeRecord($this->itemTableName, ['slug' => $slug]); // the slug is updated so the old one should not exist anymore
    }

    protected function createItem( Actor $I, $slug )
    {
        $title = 'Test post 1';
        $description = 'Lorem ipsum dolor sit amet';

        $I->fillField('title', $title);
        $I->fillField('slug', $slug);
        $I->selectOption('status', 1);
        $I->selectOption('user_id', $this->user->id);
        $I->fillField('description', $description);
        $I->fillField('short_description', $description);
        $I->click('Save');

        $I->see('saved successfully.');

        $revision = $I->grabRecord($this->revisionTableName, ['user_id' => $this->user->id]);

        $I->assertTrue( count( json_decode($revision['before'], true) ) == 6 ); // number of columns should be 6
    }

    protected function approveItem( Actor $I, $slug )
    {
        // world
        $I->amOnPage( $this->createItemURL );
        // create item
        $this->createItem( $I, $slug );
        $revision = $I->grabRecord($this->revisionTableName, ['user_id' => $this->user->id]);
        $I->amOnPage( $this->revisionsListURL . '/' . $revision['id'] );

        // assert
        $I->see('Not yet revised');
        $I->see('not approved');

        // action
        $I->click('Approve');

        // assert
        $I->see('Already revised');
        $I->see('created successfully');
        $I->seeRecord($this->itemTableName, ['slug' => $slug]); // item should be created in his real table

        return $revision;
    }
}

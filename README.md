# Laravel Revisions Module
This is a Laravel module which listens for model create and model update events and saves the edited data and the data before the edit in another table. After that the changes can be compared and approved, which will update the actual model table, or rejected.

### Requirements:
```
php: >= 5.5.9
laravel/framework: 5.2.*
laravelcollective/html: ^5.2
laracasts/flash: ^2.0
```

___

### Installation

- Make a Cluster/ folder within app/ and copy RevisionerCluster/ inside

- In config/app.php to the providers array add:
```
App\Clusters\RevisionerCluster\Providers\RevisionerClusterServiceProvider::class
```

- Run:
```
php artisan migrate --path=/app/Clusters/RevisionerCluster/Resources/Database/migrations
```

- Run:
```
php artisan vendor:publish --provider="App\Clusters\RevisionerCluster\Providers\RevisionerClusterServiceProvider"
```

- Use the RevisionableModelTrait in a model which you wan to be revisionable (App\Clusters\RevisionerCluster\Library\Traits\RevisionableModelTrait)

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Listing extends Model
{
    use HasFactory;

    // this line of code to avoid the (Add [title] to fillable property to allow mass assignment on [App\Models\Listing].) Error
    protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags', 'logo', 'user_id'];
    /*
    In Laravel, the $fillable property is used to specify which attributes of a model are mass-assignable.
    When you define the $fillable property on a model, you are essentially telling Laravel that only the
    attributes listed in the $fillable property can be mass-assigned using methods like create() or update().

    The reason for using $fillable is to protect your application from mass assignment vulnerabilities, that may lead to security risks.
    */


    //In Laravel, "scope" refers to a way to encapsulate common query constraints in your Eloquent models
    // so we dont have to rewrite a code and logic.
    // so we we want to filer things basiclly we will write write the logic in this scope function
    // and then use it in the controller class by calling it Filter()
    public function scopeFilter($query, array $filters)
    {
        if ($filters['tag'] ?? false) { // if there is a tag do what in the if statment
            $query->where('tags', 'like', '%' . request('tag') . '%'); //sql Like
            /* this is WHERE clause, In SQL, the WHERE clause is used to filter records
             returned by a SELECT, UPDATE, or DELETE statement based on a specified condition. */
        }
        //$query (which represents the query builder instance)


        if ($filters['search'] ?? false) { // if there is a tag do what in the if statment
            $query->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('tags', 'like', '%' . request('search') . '%'); //sql Like
        }
    }
    /*
even though you're not explicitly calling scopeFilter in your controller,
Laravel recognizes it as a query scope and applies it to the query builder
instance, allowing you to filter your query results based on the specified filters.

so, almost always we are using scope we use the query instace
*/


    // Relationship to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

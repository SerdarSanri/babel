# Babel

Babel is a bundle for the Laravel framework that aims to ease the task of telling users what exactly you're doing. Babel lets you input basic verbs, nouns and objects and return constructed human-readable sentences that you can output directly.
It's a very ambitious bundle but it doesn't aim to let your recreate every sentence humanly possible, just the most common ones in any application. Here are some examples of what Babel can do for the moment (which is to say not much) :

```php
// Will return "The user "Something" has been successfully deleted"
Babel::restful('user', 'Something', 'delete', true)

// Will return "The category "News" couldn't be created"
Babel::restful('category', 'News', 'create', false)

// Will return "Add an user"
Babel::add('user')

// Will return "No users to display"
Babel::no('users', 'display')

// Will return "15 categories created"
Babel::created(15, 'category')

// You can also build custom sentences
// This will output "A category was created"
$message = Babel::create()
  ->article('a')
  ->noun('category')
  ->verb('create')

// And store them to reuse them multiple times
Babel::extend('created', function($noun) {
  return Babel::create()
  ->article('a')
  ->noun($noun)
  ->verb('create')
  ->speak();
});

// Will output "A category was created"
Babel::created('category');
```

Ok now comes the question on everyone's lips. And I know what it is.

    How the hell might that be useful to me ?

Think leaner, faster, dryer and future-proof message creation. You remember when you had to write a custom message as result for every one of your application's action ? Well now you don't have to anymore. You just pass Babel the current class, and the action that just happened, and it will create all those sentences for you.

```php
class Categories_Controller
{
  public function post_create()
  {
    $message = Babel::create(__CLASS__, __FUNCTION__);

    if($somethingFails) $message->state(false);
    else {
      $message->state(true);

      // Do your usual stuff
      $model = new Model;
        $model->name = 'something';
        $model->foo  = 'bar';
      $model->save();

      $message->object($model);
    }

    return Redirect::to('something')
      ->with_message($message)
  }
}

// Failing will print out "The category couldn't be created"
// Success will print out "The category "Something" has been successfully created"
```

And there, you don't have to go trough hoops and conditions to create a message for every single situation — Babel understands what you gives it, it understands the context and pattern in a sentence, and will return the message you need.
Now this is all **very** experimental, and Babel as any localization bundle lacks yet a large enough dictionary for everyone to get what they want from it. But through time it will get better. I can't stress this enough : **I really need all the help I can find to catch syntax errors and wrong accords etc**.
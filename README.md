# Actionlogs
## Installation
You can install the package via composer:
```bash
composer require julesgraus/actionlogs
```

## Usage
### Direct logging
You can log actions directly like so:
```php
JulesGraus\Actionlogs\Actionlogs::log('your action', 'a payload');
```
The logged action wil be linked to the authenticated user if any. The payload can be anything but a resource.

### Automatic logging
The package listens to some events in the ```Illuminate\Auth\Events``` namespace by default and automatically logs those. 
This is a list of those events:
- Login
- Logout
- Failed
- Lockout
- Registered
- PasswordReset
- Verified

You can listen to extra events if you would like to. You could for example do that like so:
```php
JulesGraus\Actionlogs\Actionlogs::listenToAndLog(MyCustomEvent::class, fn(MyCustomEvent::class $event) => 'Logging something for my customevent: '.$event->user->email)
```
Put that line of code in the register method of a service provider in your implementation.

### Housekeeper
The package is compatible with ```julesgraus/housekeeper```. Register the ```JulesGraus\Actionlogs\Actionlogs``` class to the
housekeeper and read the published [config options](#configuration-and-localisation) for more info.

## Customisation
### Configuration and localisation
publish the config files and translation file of this package by running ```php artisan vendor:publish --tag=actionlogs```.
You can then edit the config file that will be put in the config dir.
And the translations that are put in ```resources/lang/vendor/actionlogs```

### Overriding the default Actionlog model
When the default ```actionlog``` model from this package does not provide the functionality you want, you can create
a custom model yourself. 

Just make sure it implements ```JulesGraus\Actionlogs\Contracts\Actionlog``` and then register it to
Laravel's container in the register method of a service provider like so:

```php
use Illuminate\Support\ServiceProvider;
use App\Actionlogs\MyCustomActionLog;
use JulesGraus\Actionlogs\Contracts\Actionlog as ActionlogContract;

class AppServiceProvider extends ServiceProvider {
    register() {
        $this->app->bind(ActionlogContract::class, MyCustomActionlog::class);
    }
}
```
Also make sure your custom implementation can accept any variable type for the payload attribute except a resource type.

### Overriding other stuff
Like the actionlog model you can also override other stuff by implementing 
and registering these interfaces in the ```JulesGraus\Actionlogs\Contracts``` namespace:
- ActionlogPolicy
- ActionlogResource
- ActionlogResourceCollection

Please bind resources and collections to a function that returns the class name of an implementation.
Else Laravel will try to instantiate the classes and nag about the resource parameter that it cannot resolve.



## Testing
Run tests by running this command in the root of the package.

```bash
composer test
```

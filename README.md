# Innovation Software task


App with integration with NBP API. It allows to check current exchange rate of PLN to other currencies. It also allows to check difference of exchange rate from the day before.


## Dependencies

* Symfony 5.4
* PHP 8.0
* MySQL 8.0

## Installing


```
git clone https://github.com/gabriela-lubkowska/innovation_software_task.git
cd innovation_software_task
composer install
symfony server:start
```

### Database setup
Edit your .env file to match your database credentials or create .env.local file with your credentials.

```
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```

## Usage

You can update exchange rates by running command:

```
bin/console nbp:exchange:update
```

or by going to '/currency/update-exchange-rates' path.

Then on the main page you can see current exchange rates. You can also check difference of exchange rate from the day before.

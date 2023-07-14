## Coding Challenge


# Setup
You can set this up to your local development environment using Docker
and the `sail` command. 
This assumes that you have already installed docker, and npm on your machine,
and are running Linux or macOS as operating system.

## Prepare CSV Files
Due to the large file sizes, I wasn't able to include the CSV files in the repository.

To prepare csv file(s) needed for migration, add the match_stats.csv, matches.csv, players.csv, teams.csv files inside the database/data
folder.

## Local Setup

Install composer packages:
```
composer install
```

Initialize local environment by running:
```
./vendor/bin/sail up -d
```

Install npm packages:
```
npm install
```


Run migrations:
```
./vendor/bin/sail artisan migrate
```

Seed database with data from database/data/csv files
**note: the seeding is limited to 2000 lines for testing purposes.
**if you want to remove this limit, you may do so in seedFromCSV lines 30 -32
```
./vendor/bin/sail artisan db:seed
```
wait for the seeding to finish

compile and run:
```
npm run dev
```

# All Set! Visit http://localhost to see the Overview Page


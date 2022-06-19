## Project set-up

- Copy .env.example to .env (you'll need binance api & glassnode api keys)
In project root folder
- Run `docker compose up -d nginx` (there should be 3 containers up & running nginx, php, mysql)
- Run `docker compose run --rm composer i`
- Run `docker compose run --rm artisan key:generate`
- Run `docker compose run --rm artisan migrate --seed` (Please note that you'll need api keys to seed the data)

### Project specific commads

- You'll need to run several calculations on historical data

`docker composer run --rm vev:rsi-calculate`

`docker composer run --rm vev:tvp-calculate`

- After this you can play with backtester

`docker composer run --rm vev:tvp-calculate {code} {range}`

(Supported codes: BTCBUSD, ETHBUSD | Supported ranges: month, week, day, hour, minute)

- Additional commands that are available
- `docker composer run --rm vev:trade {code}` (Live trading, simulates limit order creation)
- `docker composer run --rm vev:rates {code}` (Gets live candlesticks)
- `docker composer run --rm vev:candlesticks {code}` (Gets live rates)

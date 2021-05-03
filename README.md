<p align="center"><a href="https://github.com/Luca-Castelnuovo/DrinksTracker"><img src="https://camo.githubusercontent.com/0d274db00a19d2d99174dde5040ffc478923d290ea841e6f18ea20caaf10a386/68747470733a2f2f72617763646e2e6769746861636b2e636f6d2f437562655175656e63652f437562655175656e63652f383535613866653833363938396361343063346535306138383933363239373565616239616334332f7075626c69632f6173736574732f696d616765732f62616e6e65722e706e67"></a></p>

<p align="center">
<a href="https://github.com/Luca-Castelnuovo/DrinksTracker/commits/master"><img src="https://img.shields.io/github/last-commit/Luca-Castelnuovo/DrinksTracker" alt="Latest Commit"></a>
<a href="https://github.com/Luca-Castelnuovo/DrinksTracker/issues"><img src="https://img.shields.io/github/issues/Luca-Castelnuovo/DrinksTracker" alt="Issues"></a>
<a href="LICENSE.md"><img src="https://img.shields.io/github/license/Luca-Castelnuovo/DrinksTracker" alt="License"></a>
</p>

# DrinksTracker

Track drinks

- [Homepage](https://drinks.castelnuovo.xyz)

## Installation

For development

1. `git clone https://github.com/Luca-Castelnuovo/DrinksTracker.git`
2. `composer install`
3. Edit `.env`
4. `php cubequence app:key`
5. `php cubequence db:migrate`
6. `php cubequence db:seed`
7. Start development server `php -S localhost:8080 -t public`

For production

1. `git clone https://github.com/Luca-Castelnuovo/DrinksTracker.git`
2. `composer install --optimize-autoloader --no-dev`
3. Edit `.env`
4. `php cubequence app:key`
5. `php cubequence db:migrate`

## Security Vulnerabilities

Please review [our security policy](https://github.com/Luca-Castelnuovo/DrinksTracker/security/policy) on how to report security vulnerabilities.

## License

Copyright © 2020 [Luca Castelnuovo](https://github.com/Luca-Castelnuovo). <br />
This project is [MIT](LICENSE.md) licensed.

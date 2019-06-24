### Mean Squared Error
A regression metric that punishes bad predictions the worse they get by averaging the *squared* error  over the testing set.

> [Source](https://github.com/RubixML/RubixML/blob/master/src/CrossValidation/Metrics/MeanSquaredError.php)

**Compatibility:** Regression

**Range:** -∞ to 0

**Example:**

```php
use Rubix\ML\CrossValidation\Metrics\MeanSquaredError;

$metric = new MeanSquaredError();
```
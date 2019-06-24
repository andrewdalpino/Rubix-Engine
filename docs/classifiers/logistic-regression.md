### Logistic Regression
A type of linear classifier that uses the logistic (*sigmoid*) function to estimate the probabilities of exactly *two* classes.

> [Source](https://github.com/RubixML/RubixML/blob/master/src/Classifiers/LogisticRegression.php)

**Interfaces:** [Estimator](#estimators), [Learner](#learner), [Online](#online), [Probabilistic](#probabilistic), [Verbose](#verbose), [Persistable](#persistable)

**Compatibility:** Continuous

**Parameters:**

| # | Param | Default | Type | Description |
|---|---|---|---|---|
| 1 | batch size | 100 | int | The number of training samples to process at a time. |
| 2 | optimizer | Adam | object | The gradient descent optimizer used to train the underlying network. |
| 3 | alpha | 1e-4 | float | The amount of L2 regularization to apply to the weights of the network. |
| 4 | epochs | 1000 | int | The maximum number of training epochs to execute. |
| 5 | min change | 1e-4 | float | The minimum change in the cost function necessary to continue training. |
| 6 | cost fn | Cross Entropy | object | The function that computes the cost of an erroneous activation during training. |

**Additional Methods:**

Return the average loss of a sample at each epoch of training:
```php
public steps() : array
```

Return the underlying neural network instance or *null* if untrained:
```php
public network() : Network|null
```

**Example:**

```php
use Rubix\ML\Classifers\LogisticRegression;
use Rubix\ML\NeuralNet\Optimizers\Adam;
use Rubix\ML\NeuralNet\CostFunctions\CrossEntropy;

$estimator = new LogisticRegression(10, new Adam(0.001), 1e-4, 100, 1e-4, new CrossEntropy());
```
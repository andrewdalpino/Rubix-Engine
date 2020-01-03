# What is Machine Learning?
Machine learning (ML) is a form of programming that uses data to train a computer to make predictions (referred to as *inference*) about unknown or future outcomes. Unlike traditional programming in which rules are programmed explicitly, machine learning uses data to induce rulesets automatically through training. At a high level, machine learning is a collection of techniques borrowed from many disciplines such as statistics, probability theory, and information theory combined with novel ideas for the purpose of gaining insight through data. The field of Machine Learning is further broken down into subcategories based on the problems they aim to solve.

## Supervised Learning
Supervised learning is a type of machine learning that incorporates a training signal in the form of human annotations called *labels* along with the training samples. Labels can be thought of as the desired output of a learner given the sample we are showing it. Supervised learners are tasked with forming a mapping from input to prediction based on these input-output pairs. There are two types of supervised learning to consider in Rubix ML.

### Classification
For classification problems, a supervised learner is trained to differentiate samples among a set of *k* possible discrete classes. In this type of problem, the training labels are the classes that each sample belongs to. Examples of class labels include `cat`, `dog`, `human`, etc. Classification problems range from simple to very complex and include [image recognition](https://github.com/RubixML/CIFAR-10), [text sentiment analysis](https://github.com/RubixML/Sentiment), and [Iris flower classification](https://github.com/RubixML/Iris).

### Regression
Regression is a learning problem that aims to predict a continuous-valued outcome. In this case, the training labels are continuous data types such as integers and floating point numbers. Unlike classifiers, the range of predictions that a regressor can make is infinite. Regression problems include determining the angle of the steering wheel of an automobile, estimating the [sale price of a home](https://github.com/RubixML/Housing), and credit scoring.

## Unsupervised Learning
A form of learning that does not require training labels is called Unsupervised learning. Unsupervised learners aim to detect patterns using just raw samples. Since it is not always easy or possible to obtain labeled data, an unsupervised method is often the first step in discovering information about your data. There are three types of unsupervised learning to consider in Rubix ML.

### Clustering
Clustering takes a dataset of unlabeled samples and assigns each a discrete cluster number based on its similarity to other samples from the training set. Clustering is used in tissue differentiation from PET scan images, customer database market segmentation, and to discover communities within social networks.

### Anomaly Detection
Anomalies are samples that have been generated by a different process than normal or those that do not conform to the expected distribution of the training data. Samples can either be flagged or ranked based on their anomaly score. Anomaly detection is used in information security for intrusion and denial of service detection, and in the financial industry to detect fraud.

### Manifold Learning
Manifold learning is a type of unsupervised non-linear dimensionality reduction used for embedding datasets into dense feature representations. Embedders can be used for visualizing high dimensional (3 or more) datasets in low (1 to 3) dimensions, and for compressing samples before input to a learning algorithm.

## Other Forms of ML
Although the supervised and unsupervised learning framework covers a substantial number of problems, there are other types of machine learning that Rubix ML does *not* support out of the box.

### Reinforcement Learning
Reinforcement Learning (RL) is a type of machine learning that aims to learn the optimal control of an agent within an environment through cumulative reward. The data used to train an RL learner are the states obtained by performing some action and then observing the response. If supervised learning is learning by example then reinforcement learning is learning from mistakes. Reinforcement learning is used to train AIs to play games such as Go, Chess, and Starcraft 2, as well as for teaching robots how to perform movements such as walking or grasping an object.
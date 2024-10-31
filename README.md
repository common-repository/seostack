

![Build status](https://api.travis-ci.org/seostack/seostack-for-wordpress.svg?branch=master)
[![Code Climate](https://codeclimate.com/github/seostack/seostack-for-wordpress/badges/gpa.svg)](https://codeclimate.com/github/seostack/seostack-for-wordpress)


# seostack for WordPress
Optimize your internal site search by using our professional algorithm. This plugin uses the seostack API, for the best performance and instant updates in the search algorithm.

## Site owners and users
This plugin integrates the seostack services with WordPress. Our [hosted site search](https://seostack.io/hosted-site-search/) can be used for free, but there will be a limit of 250 indexed documents. You can upgrade your API key on the [seostack website](https://seostack.io/hosted-site-search/).

### Reporting issues
You can report issues regarding this WordPress plugin on our [GitHub page](https://github.com/seostack/seostack-for-wordpress/). When you're having other issues, or you want personal support, you can contact us by visiting our website. [Our support department](https://seostack.io/support/) is more than happy to help you!

## Developers
If you want to contribute to this open-source plugin, you can fork this repository. After you've made your changes, updated the tests and verified your code, you may create a pull request. The PR needs to be created from your fork into our ``develop`` branch. 

We will check your code with a code review, and if it's approved we will merge it into our ``develop`` and ``master`` branches.
 
### Running tests
We assume that you have [WordPress Develop](https://github.com/WordPress/wordpress-develop) installed in ``/tmp/wordpress``. 

You can run the test suite of this plugin from the plugin directory ``seostack-for-wordpress`` with this command:
 
 > $ phpunit
 
 The test suite is also triggered from GitHub on our [Travis page](https://travis-ci.org/seostack/seostack-for-wordpress). Each commit and pull request will trigger the build on Travis, so the code is verified immediately.
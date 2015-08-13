# BitbucketSimpleGetter
Simple getter for BitBucket API which allowes you to get most of the data from BitBucket API.

Api class has only one public method called *query* and as a param provide a repository which you want to access. 
BitBucket API Browser - http://restbrowser.bitbucket.org/

For example if you want to access to this resource: https://bitbucket.org/api/1.0/repositories/hipchat/chatty/branches/ use example below.

**Usage example**
```php
<?php
use BitbucketSimpleGetter\Api as BitbucketApi;

$config = [
    'bitbucketArea' => 'repositories',
    'repoOwner' => 'hipchat',
    'repoName' => 'chatty',
    'username' => 'YOUR_USERNAME',
    'password' => 'YOUR_PASSWORD'
];

        $bitbucketApi = new BitbucketApi($config);
        $branches = $bitbucketApi->query('branches');
        
        var_dump($branches);
```
Example output:
```bash
object(stdClass)#27 (3) {
  ["master"]=>
  object(stdClass)#22 (12) {
    ["node"]=>
    string(12) "a1905954312d"
    ["files"]=>
    array(1) {
      [0]=>
      object(stdClass)#21 (2) {
        ["type"]=>
        string(8) "modified"
        ["file"]=>
        string(12) "package.json"
      }
    }
    ["raw_author"]=>
    string(36) "--cut--"
    ["utctimestamp"]=>
    string(25) "2015-03-13 16:41:21+00:00"
    ["author"]=>
    string(8) "--cut--"
    ["timestamp"]=>
    string(19) "2015-03-13 17:41:21"
    ["raw_node"]=>
    string(40) "a1905954312d7921e0409ba71c85205fe001ae18"
    ["parents"]=>
    array(1) {
      [0]=>
      string(12) "b52647b502fa"
    }
    ["branch"]=>
    string(6) "master"
    ["message"]=>
    string(8) "Up deps
"
    ["revision"]=>
    NULL
    ["size"]=>
    int(-1)
  }
  (...)
}
```

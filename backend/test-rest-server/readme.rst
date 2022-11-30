********
REST API
********

**I did this project for some test purposes**

URL for online test => `Demo <https://hofarismail.site/test-rest-server/api/article>`_

*********
Show data
*********
to display data, you can use "GET" method

.. code-block:: javascript

    var settings = {
      "url": "http://localhost:8080/test09/backend/test-rest-server/api/article/",
      "method": "GET",
      "timeout": 0,
    };

    $.ajax(settings).done(function (response) {
      console.log(response);
    });

if success, you will get response with code 200 OK

.. code-block:: json

    {
        "status": true,
        "data": [
            {
                "id": "1",
                "title": "test",
                "content": "test",
                "category": "test",
                "created_date": "2022-11-30 09:16:09",
                "updated_date": "2022-11-30 09:15:28",
                "status": "Publish"
            }
        ]
    }


***********
Insert data
***********
to insert data, you can use "POST" method

..  code-block:: javascript

    var settings = {
      "url": "http://localhost:8080/test09/backend/test-rest-server/api/article/",
      "method": "POST",
      "timeout": 0,
      "headers": {
        "Content-Type": "application/json"
      },
      "data": JSON.stringify({
        "title": "testC",
        "content": "testC",
        "category": "testC",
        "status": "Draft"
      }),
    };

    $.ajax(settings).done(function (response) {
      console.log(response);
    });

if succesed, you will get response 200 OK

.. code-block:: javascript

    {
        "status": true,
        "data": {
            "title": "testC2",
            "content": "testC",
            "category": "testC2",
            "status": "Draft",
            "id": "8"
        },
        "message": "inserted!"
    }

***********
Update data
***********
to update data, you can use "POST", "PUT" or "PATCH" method with **id** required

.. code-block:: javascript

    var settings = {
      "url": "http://localhost:8080/test09/backend/test-rest-server/api/article/8", // id in URL parameter
      "method": "POST", // POST or PUT or PATCH
      "timeout": 0,
      "headers": {
        "Content-Type": "application/json"
      },
      "data": JSON.stringify({
        "title": "testC2",
        "content": "testC",
        "category": "testC2",
        "status": "Draft"
      }),
    };

    $.ajax(settings).done(function (response) {
      console.log(response);
    });

if succesed, you will get response 200 OK

.. code-block:: javascript

    {
        "status": true,
        "data": {
            "title": "testC2",
            "content": "testC",
            "category": "testC2",
            "status": "Draft",
            "id": "8"
        },
        "message": "updated!"
    }

***********
Delete data
***********
to delete data, you can use "DELETE" method

.. code-block:: javascript

    var settings = {
      "url": "http://localhost:8080/test09/backend/test-rest-server/api/article/5",
      "method": "DELETE",
      "timeout": 0,
    };

    $.ajax(settings).done(function (response) {
      console.log(response);
    });

if succesed, you will get response 204 No Content


*************
About project
*************

###################
What is CodeIgniter
###################

CodeIgniter is an Application Development Framework - a toolkit - for people
who build web sites using PHP. Its goal is to enable you to develop projects
much faster than you could if you were writing code from scratch, by providing
a rich set of libraries for commonly needed tasks, as well as a simple
interface and logical structure to access these libraries. CodeIgniter lets
you creatively focus on your project by minimizing the amount of code needed
for a given task.

*******************
Release Information
*******************

This repo contains in-development code for future releases. To download the
latest stable release please visit the `CodeIgniter Downloads
<https://codeigniter.com/download>`_ page.

**************************
Changelog and New Features
**************************

You can find a list of all changes for each release in the `user
guide change log <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/changelog.rst>`_.

*******************
Server Requirements
*******************

PHP version 5.6 or newer is recommended.

It should work on 5.3.7 as well, but we strongly advise you NOT to run
such old versions of PHP, because of potential security and performance
issues, as well as missing features.

************
Installation
************

Please see the `installation section <https://codeigniter.com/user_guide/installation/index.html>`_
of the CodeIgniter User Guide.

*******
License
*******

Please see the `license
agreement <https://github.com/bcit-ci/CodeIgniter/blob/develop/user_guide_src/source/license.rst>`_.

*********
Resources
*********

-  `User Guide <https://codeigniter.com/docs>`_
-  `Language File Translations <https://github.com/bcit-ci/codeigniter3-translations>`_
-  `Community Forums <http://forum.codeigniter.com/>`_
-  `Community Wiki <https://github.com/bcit-ci/CodeIgniter/wiki>`_
-  `Community Slack Channel <https://codeigniterchat.slack.com>`_

Report security issues to our `Security Panel <mailto:security@codeigniter.com>`_
or via our `page on HackerOne <https://hackerone.com/codeigniter>`_, thank you.

***************
Acknowledgement
***************

The CodeIgniter team would like to thank EllisLab, all the
contributors to the CodeIgniter project and you, the CodeIgniter user.

Standard PHP Interface Library (SPIL)
=====================================

**This is a proof of concept release, and isn't fleshed out.  It doesn't contain
much in the way of useful interfaces or classes (yet).  The classes and interfaces
which are included haven't been well thought out and should be expected to change.
Please use this to explore the concept of SPIL bearing this in mind.**

SPIL is a set of standard interfaces for common PHP classes, plus a loader to load
concrete implementations of those interfaces from remote repositories to your
development environment.  Put simply, after you install SPIL you can auto-install
classes from the SPIL library as needed without having to load any heavy-weight
frameworks.

SPIL can be set up to work with any number of different repositories which may
provide different implementations of SPIL interfaces, but because they all conform
to the same interfaces those different implementations *should* work together
interchangeably.

At the same time SPIL facilitates code sharing between frameworks with the hope that
different framework suppliers might work together on the common stuff and focus
instead on what differentiates their framework from the others.

SPIL was inspired by a [/dev/hell podcast](http://devhell.info) which provoked this
blog post:

<http://blog.vicmetcalfe.com/2011/12/23/spil-a-non-framework-proposal-for-php/>

Installing SPIL
---------------

Get the source from <https://github.com/zymsys/SPIL> and put it somewhere on your
filesystem.  Add that location to the PHP include path so that including
SPIL/Loader.php will find Loader.php.  On my mac for example I have a php
folder in my home directory, and I have SPIL under that.  In my php.ini I have

> include_path = ".:/usr/local/pear/share/pear:/usr/local/zf/library:/Users/vic/php"

This includes the current folder, PEAR, Zend Framework and my own php folder.  My
php folder has a folder called SPIL which contains the SPIL code.

Now make sure that the classes and interfaces folders are world-writable, or at
least writable by your web server.  This isn't a good security practice for your
production systems, but in development it allows SPIL to auto-load new classes as
needed.  For Linux and Mac users, from the main SPIL folder run:

> chmod -R 777 classes interfaces

I haven't yet tested SPIL on Windows, but plan to do so soon.  Permissions under
IIS make me shudder, but I expect you just need to go to the folder's security
settings and add Everybody with the Full Control right.

SPIL also currently requires the PEAR HTTP_Request2 module in order to load
remote classes and interfaces.  It can be found here:

<http://pear.php.net/manual/en/package.http.http-request2.php>

If you have PEAR already set up then it can be installed with just:

> pear install HTTP_Request2

Hopefully SPIL can provide this feature itself soon and eliminate the dependency on
PEAR.  I'd actually like to see SPIL available on PEAR when it matures since the two
complement each other.

Using SPIL
----------

Require the SPIL loader in your bootstrap file, or some other location which loads
it before you need to use any SPIL classes:

> require_once('SPIL/Loader.php');

Next add any repositories you want to load classes from, in the order you prefer
to use them.  They are checked in the order they were registered.

> SPIL_Loader::registerRepository('http://repo.spil.l.vicmetcalfe.com/index.php');

Then you can just go ahead and start using SPIL classes as needed.  The Loader.php
script sets up an auto-loader which loads the local copy first, and then tries
the repositories it knows in order until it finds the class or fails.  If it does
find the class it makes a local copy and loads that.

The repo at the address in the example above includes a class not in the distribution
for testing purposes called SPIL_DataMapper_Serialize.  You can test it by running
example.php from the project's root folder.

Adding Your Own Classes
-----------------------

If you want to make your own classes available to other projects on your own box
you can just copy them into your classes folder.  Underscores in class names
translate into folder names in the classes folder.  The SPIL_ prefix tells the
loader that it should attempt to load the class.  The ISPIL_ prefix tells it to
try and load an interface from the interfaces folder.  The interface is optional
for your own classes and repositories (see below).

So, if you've make a class called SPIL_My_Class then you should copy it the
classes folder in this location:

> SPIL/classes/My/Class.php

Setting up a SPIL Repository
----------------------------

The index.php script in the server folder provides the repository script.  It is
fairly straight forward.  After you've installed SPIL you can put this script
anywhere on the server with SPIL, and it can be used to serve up the SPIL classes
and interfaces known to that server.
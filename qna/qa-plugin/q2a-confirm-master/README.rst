===========================
Question2Answer Confirm 1.0b1
===========================
-----------
Description
-----------
This is a plugin for **Question2Answer** that provides confirm dialogues when leaving text in a textarea.

--------
Features
--------
- checks all textareas on key up to see if there is still text in one of them, adds the function to onbeforeunload
- checks at document.onload, for error submissions
- shows confirm when leaving unless it is a form submission

------------
Installation
------------
#. Install Question2Answer_
#. Get the source code for this plugin from github_, either using git_, or downloading directly:

   - To download using git, install git and then type 
     ``git clone git://github.com/NoahY/q2a-confirm.git embed``
     at the command prompt (on Linux, Windows is a bit different)
   - To download directly, go to the `project page`_ and click **Download**

#. navigate to your site, go to **Admin -> Plugins** on your q2a install and select the '**Enable confirmation dialogue**' option, then '**Save**'.

.. _Question2Answer: http://www.question2answer.org/install.php
.. _git: http://git-scm.com/
.. _github:
.. _project page: https://github.com/NoahY/q2a-confirm

----------
Disclaimer
----------
This is **beta** code.  It is probably okay for production environments, but may not work exactly as expected.  Refunds will not be given.  If it breaks, you get to keep both parts.

-------
Release
-------
All code herein is Copylefted_.

.. _Copylefted: http://en.wikipedia.org/wiki/Copyleft

---------
About q2A
---------
Question2Answer is a free and open source platform for Q&A sites. For more information, visit:

http://www.question2answer.org/


Arma-Whitelist-PHP-Interface
============================

A Interface where every player can add his GUID to a MySQL DB by self

Features
--------
- Users can add her GUID to a whitelist by her self
- Users must login first with her wbb 3 Login Data
- Admin Interface to edit or delete whitelisted Users
- Permission System for Admin Interface
- Users must add her Arma 2 Ingame Name to a custom profile field in the wbb

Requirements
------------
- Webspace (yes realy ;))
- MySQL Server
- Arma 2 Whitelist Tool with support MySQL Databases
- wbb Forum 3 for Login of Users

Installation
------------
1. Download files
2. Upload files to your Webspace
3. Create a Database
4. Import "whitelist test.sql" file in your new Database
5. Open "db.php" and Enter your MySql Connection Data to your new Database
6. Add a custom Userfield to your wbb
6. Open "config.php" and edit all requirements
7. Add you self first to the whitelist and change your Permission in the Database to "2" instead of "1" to get Access to the Admin Panel

Licence
-------
1. Dont Change the Copyright

ToDo
----
- Add Multi Language Support

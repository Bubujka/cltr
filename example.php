<?php
require 'cltr.php';

cltr\pdo_host('localhost');
cltr\pdo_dbname('my_blog');
cltr\pdo_user('root');
cltr\pdo_password('OloloO111');
cltr\pdo_table('page_time');

cltr\start();
sleep(1);
cltr\stop();

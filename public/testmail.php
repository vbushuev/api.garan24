<?php
if(!mail("v.bushuev@garan24.ru","test php mail","PHP:mail()\r\n.")){
    echo json_encode(error_get_last(),JSON_PRETTY_PRINT);
}
else echo "TEST message are sent.";
?>

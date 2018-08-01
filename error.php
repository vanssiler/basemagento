<html>
<body>
<?php
error_reporting(E_ALL | E_STRICT);
$mageFilename = 'app/Mage.php';
require_once $mageFilename;
Mage::setIsDeveloperMode(true);
ini_set('display_errors', 1);
ini_set('memory_limit', '600M');
ini_set('max_execution_time', 1800);
umask(0);
Mage::app('admin');
?>
<?php
$cat = Mage::getModel('catalog/category')->load(2);
$subcats = $cat->getChildren();
$products_row = array();
foreach(explode(',',$subcats) as $subCatid)
{
    $data = array();
    $_category = Mage::getModel('catalog/category')->load($subCatid);
    if($_category->getIsActive()) {
        $data[] =   $_category->getName();
        $data[] =   str_replace('/getCat.php','',$_category->getURL());
        $sub_cat = Mage::getModel('catalog/category')->load($_category->getId());
        $sub_subcats = $sub_cat->getChildren();
        foreach(explode(',',$sub_subcats) as $sub_subCatid)
        {
            $_sub_category = Mage::getModel('catalog/category')->load($sub_subCatid);
            if($_sub_category->getIsActive()) {
                $data[] = $_category->getName().' >> '.$_sub_category->getName();
                $data[] =   str_replace('/getCat.php','',$_sub_category->getURL());

                $sub_sub_cat = Mage::getModel('catalog/category')->load($sub_subCatid);
                $sub_sub_subcats = $sub_sub_cat->getChildren();
                foreach(explode(',',$sub_sub_subcats) as $sub_sub_subCatid)
                {
                    $_sub_sub_category = Mage::getModel('catalog/category')->load($sub_sub_subCatid);
                    if($_sub_sub_category->getIsActive()) {
                        $data[]= $_category->getName().' >> '.$_sub_category->getName().' >> '.$_sub_sub_category->getName();
                        $data[] = str_replace('/getCat.php','',$_sub_sub_category->getURL());

                    }
                }
            }
        }

    }

    $products_row[] = $data;
}
echo '<pre>';
print_r($products_row);
echo '<pre>';
?>
</body>
</html>
<?php
/**
* Baseado em conteúdo disponível na internet
* Este altera o atributo is_anchor de todas as categorias exxtentes na loja para 1
* 
* @author Ronaldo Diniz <ronaldo@ronaldodiniz.com.br>
* @license GNU
* 
*/

//Define local de instalação
define('MAGENTO', realpath(dirname(__FILE__)));
//inicia Aplicação do Magento
require_once MAGENTO . '/app/Mage.php';
umask(0);
Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

$storeIds = Mage::getModel('core/store')->getCollection()->getAllIds();
$category = Mage::getModel('catalog/category');
$tree = $category->getTreeModel();
$tree->load();
$ids = $tree->getCollection()->getAllIds();
asort($ids);
$categories = array();


echo "<p>Iniciando alterações</p>";

echo "<p>\n";

if($ids) {
    foreach ( $ids as $id ) {
        foreach ($storeIds as $storeId) {
            if ($storeId == 0) {
                continue;
            }
            $cat = $category->setStoreId($storeId)->load($id);
            if($cat->getId()) {
                $cat->setIsAnchor(1);
                $cat->save();
                echo "categoria <b>{$cat->getName()}</b> alterada com sucesso.<br>\n";
            }
        }
    }
}

echo "</p>\n";

echo "<p>Fim das alterações</p>";

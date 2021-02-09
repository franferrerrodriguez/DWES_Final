<?php

require_once('db/db.class.php');
require_once('Article.class.php');
require_once('Category.class.php');

class ArticleCategory {

    private $articleId;
    private $categoryId;

    function __construct($articleId, $categoryId) {
        $this->articleId = $articleId;
        $this->categoryId = $categoryId;
    }

    public function setArticleId($articleId) {
        $this->articleId = $articleId;
    }

    public function getArticleId() {
        return $this->articleId;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }

    static function getAll() {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from ARTICLES_CATEGORIES");
            $stmt->execute();
            $records = $stmt->fetchAll();
        }

        $objects = [];
        foreach ($records as $index => $r) {
            $object = new ArticleCategory($r['article_id'], $r['category_id']);
            $object->id = $r['id'];
            array_push($objects, $object);
        }

        $db->cerrarConn();
        return $objects;
    }

    static function getById($articleId, $categoryId) {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * FROM ARTICLES_CATEGORIES WHERE article_id = :articleId AND category_id LIKE :categoryId");
            $stmt->execute(array(
                ':articleId' => $articleId,
                ':categoryId' => $categoryId
            ));
            $stmt->execute();
            $records = $stmt->fetchAll();
            if($records) {
                $r = $records[0];
                $object = new ArticleCategory($r['article_id'], $r['category_id']);
                return $object;
            } else {
                return null;
            }
        }
        $db->cerrarConn();
        return $records;
    }

    function save() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "INSERT INTO ARTICLES_CATEGORIES(article_id, category_id) VALUES
                (:articleId, :categoryId)"
            );
    
            $stmt->execute(array(
                ':articleId' => $this->articleId,
                ':categoryId' => $this->categoryId
            ));
        }
        
        $db->cerrarConn();
    }

    static function delete($articleId, $categoryId) {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "DELETE FROM ARTICLES_CATEGORIES WHERE article_id LIKE :articleId AND category_id LIKE :categoryId"
            );
    
            $stmt->execute(array(
                ':articleId' => $articleId,
                ':categoryId' => $categoryId
            ));
        }

        $db->cerrarConn();
    }

    static function getCategoriesByArticleId($articleId) {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from ARTICLES_CATEGORIES WHERE article_id = :articleId");
            $stmt->execute(array(
                ':articleId' => $articleId
            ));
            $stmt->execute();
            $records = $stmt->fetchAll();
        }
        $db->cerrarConn();

        $categories = [];
        foreach ($records as $index => $value) {
            $category = Category::getById($value[1]);
            if($category) {
                array_push($categories, $category);
            }
        }

        return $categories;
    }

    static function getArticlesByCategoryId($categoryId) {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from ARTICLES_CATEGORIES WHERE category_id = :categoryId");
            $stmt->execute(array(
                ':categoryId' => $categoryId
            ));
            $stmt->execute();
            $records = $stmt->fetchAll();
        }
        $db->cerrarConn();

        $articles = [];
        foreach ($records as $index => $value) {
            $article = Article::getById($value[0]);
            if($article) {
                array_push($articles, $article);
            }
        }

        return $articles;
    }

    static function deleteByArticleId($articleId) {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "DELETE FROM ARTICLES_CATEGORIES WHERE article_id LIKE :articleId"
            );
    
            $stmt->execute(array(
                ':articleId' => $articleId
            ));
        }

        $db->cerrarConn();
    }
    
}

?>
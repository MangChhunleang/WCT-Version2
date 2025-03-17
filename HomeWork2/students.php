<?php
session_start();

class Student {
    public $id;
    public $name;
    public $age;
    public $grade;

    public function __construct($id, $name, $age, $grade) {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->grade = $grade;
    }
}

if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $newId = time();
                $student = new Student(
                    $newId,
                    $_POST['name'],
                    $_POST['age'],
                    $_POST['grade']
                );
                $_SESSION['students'][$newId] = $student;
                header('Location: index.html');
                break;

            case 'edit':
                $id = $_POST['id'];
                $_SESSION['students'][$id]->name = $_POST['name'];
                $_SESSION['students'][$id]->age = $_POST['age'];
                $_SESSION['students'][$id]->grade = $_POST['grade'];
                header('Location: index.html');
                break;

            case 'delete':
                $id = $_POST['id'];
                unset($_SESSION['students'][$id]);
                header('Location: index.html');
                break;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_students') {
    header('Content-Type: application/json');
    echo json_encode(array_values($_SESSION['students']));
    exit;
}
?> 
<?php
/**
 * LavaLust PHP Framework
 *
 * IO Handler
 */

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Io {

    /**
     * Detect Request Method (GET, POST, AJAX)
     */
    public function method() {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }


    /**
     * GET DATA (SAFE)
     * - Prevents "Undefined array key"
     * - Works even if ?search= is missing
     */
    public function get($index = null) {
        if ($index === null) {
            return $_GET;
        }

        return $_GET[$index] ?? null;   // ✔ Fixed: no warning
    }


    /**
     * POST DATA (SAFE)
     */
    public function post($index = null) {
        if ($index === null) {
            return $_POST;
        }

        return $_POST[$index] ?? null;
    }


    /**
     * GET OR POST
     */
    public function input($index = null) {
        if ($index === null) {
            return array_merge($_GET, $_POST);
        }

        if (isset($_POST[$index])) {
            return $_POST[$index];
        }

        return $_GET[$index] ?? null;
    }


    /**
     * RAW input (JSON)
     */
    public function raw() {
        return file_get_contents("php://input");
    }


    /**
     * Check if AJAX
     */
    public function is_ajax() {
        return (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        );
    }

}

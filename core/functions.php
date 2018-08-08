<?php
/**
 * Проверяет, является ли метод ответа POST
 * @return bool
 */
function isPost()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}
/**
 * Проверяет установлен ли параметр $name в запросе
 * @param $name
 * @return null
 */
function getParam($name)
{
    return isset($_REQUEST[$name]) ? $_REQUEST[$name] : null;
}
/**
 * Отправляет переадресацию на указанную страницу
 * @param $action
 */
function redirect($action, $parameters)
{
    $parameters = isset($parameters) ? $parameters : '';
    header('Location: ' . $action . '.php' . $parameters);
    die;
}
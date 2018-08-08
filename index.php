<?php
require_once 'core/core.php';


/* Параметры подключения к БД и загрузчик классов размещен в файле core/core.php */
/* Выполнение задач в зависимости от нажатых кнопок */
$tableName = getParam('tableName');
$action = getParam('action');
//$fieldName = !empty(getParam('addFieldName')) ? getParam('addFieldName') : getParam('fieldName');
$fieldName = getParam('fieldName');
if (!empty($tableName) && !empty($fieldName)
    && (!empty(getParam('newFieldName')) or !empty(getParam('newFieldType')) or ($action === 'del'))
) {
    $dataBase->getTable($tableName)->changeField(
        $action,
        $fieldName,
        getParam('newFieldName'),
        getParam('newFieldType')
    );
    redirect('index', '?tableName=' . $tableName);
}
/* Если нажали добавить поле */
if (!empty($tableName) && !empty(getParam('addFieldName')) && !empty(getParam('add'))) {
    $dataBase->getTable($tableName)->addField(getParam('addFieldName'), getParam('addFieldType'));
    redirect('index', '?tableName=' . $tableName);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Домашнее задание по теме <?= $homeWorkNum ?> <?= $homeWorkCaption ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
<h1>Работа с таблицами</h1>
<div class="form-container">
    <h2>В базе данных <?= DB ?> находятся следующие таблицы:</h2>
    <div class="container">
        <ul>
            <?php /* Выводим названия таблиц в виде списка */
            foreach ($dataBase->getTables() as $table) {
                echo '<li><a href="?tableName=' . $table->getTableName() . '">' . $table->getTableName() . '</a></li>';
            }
            ?>
        </ul>
    </div>

    <?php if (!empty(getParam('tableName'))): /* Если была выбрана таблица - выводим ее поля */ ?>
        <form action="index.php" method="GET">
            <h2>Таблица <?= getParam('tableName') ?> содержит следующие поля:</h2>
            <table>
                <tr>
                    <th>Название (name)</th>
                    <th>Тип (type)</th>
                    <th>Может ли быть null (null)</th>
                    <th>Ключ (key)</th>
                    <th>Значение по-умолчанию (default)</th>
                    <th>Название (extra)</th>
                    <th>Управление</th>
                </tr>
                <?php
                foreach ($dataBase->getTable(getParam('tableName'))->getFields() as $field) {
                    $link = '?tableName=' . getParam('tableName') . '&fieldName=' . $field->getName();
                    $editMode = (getParam('fieldName') === $field->getName());
                    /* $editMode = true если имя поля $field совпадает с таковым в POST - запросе */
                    echo '<tr>';
                    echo '  <td>'; /* колонка с именами полей */
                    if ($editMode && getParam('action') === 'editName') {
                        echo '<input type="text" name="newFieldName" value="' . $field->getName() . '"/>';
                    } else {
                        echo $field->getName();
                    }
                    echo '  </td>';
                    echo '  <td>'; /* колонка с типами полей */
                    if ($editMode && getParam('action') === 'editType') {
                        echo '    <label title="">';
                        echo '      <select name="newFieldType">';
                        foreach ($dataBase->getTable(getParam('tableName'))->getFieldTypes() as $fieldType) :
                            echo '        <option value="' . $fieldType . '">' . $fieldType . '</option>';
                        endforeach;
                        echo '      </select>';
                        echo '    </label>';
                    } else {
                        echo $field->getType();
                    }
                    echo '  </td>';
                    echo '  <td>' . $field->getNull() . '</td>';
                    echo '  <td>' . $field->getKey() . '</td>';
                    echo '  <td>' . $field->getDefault() . '</td>';
                    echo '  <td>' . $field->getExtra() . '</td>';
                    echo '  <td>'; /* колонка с кнопками управления */
                    if (!$editMode) {
                        echo '    <a href="' . $link . '&action=editName">Изменить имя</a> |';
                        echo '    <a href="' . $link . '&action=del">Удалить</a> |';
                        echo '    <a href="' . $link . '&action=editType">Изменить тип</a>';
                    } else {
                        echo '    <input type="hidden" name="tableName" value="' . getParam('tableName') . '">';
                        echo '    <input type="hidden" name="action" value="' . getParam('action') . '">';
                        echo '    <input type="hidden" name="fieldName" value="' . getParam('fieldName') . '">';
                        echo '    <input type="submit" name="save" value="Сохранить"/>';
                    }
                    echo '  </td>';
                    echo '</tr>';
                }
                echo '<tr>';
                echo '  <td><input type="text" name="addFieldName" value=""/></td>';
                echo '  <td>'; /* колонка с типами полей */
                echo '    <label title="">';
                echo '      <select name="addFieldType">';
                foreach ($dataBase->getTable(getParam('tableName'))->getFieldTypes() as $fieldType) :
                    echo '        <option value="' . $fieldType . '">' . $fieldType . '</option>';
                endforeach;
                echo '      </select>';
                echo '    </label>';
                echo '  </td>';
                echo '  <td>NO</td>';
                echo '  <td></td>';
                echo '  <td></td>';
                echo '  <td></td>';
                echo '  <td>';
                echo '    <input type="hidden" name="tableName" value="' . getParam('tableName') . '">';
                echo '    <input type="submit" name="add" value="Добавить строку"/>';
                echo '  </td>';
                echo '</tr>';
                ?>
            </table>

        </form>
    <?php endif; ?>

</div>
</body>
</html>
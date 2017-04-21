<?php

namespace ait\keystorage\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use ait\keystorage\models\KeyStorageFormModel;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class KeyStorage extends Widget
{
    /**
     * @var KeyStorageFormModel
     */
    public $model;
    /**
     * @var string
     */
    public $formClass = '\yii\widgets\ActiveForm';
    /**
     * @var array
     */
    public $formOptions;
    /**
     * @var string
     */
    public $submitText;
    /**
     * @var array
     */
    public $submitOptions;

    /**
     * @throws InvalidConfigException
     */
    public function run()
    {
        $model = $this->model;
        $form = call_user_func([$this->formClass, 'begin'], $this->formOptions);
        foreach ($model->keys as $key => $config) {
            $type = ArrayHelper::getValue($config, 'type', KeyStorageFormModel::TYPE_TEXTINPUT);
            $options = ArrayHelper::getValue($config, 'options', []);
            $field = $form->field($model, $key);
            $items = ArrayHelper::getValue($config, 'items', []);
            switch ($type) {
                case KeyStorageFormModel::TYPE_TEXTINPUT:
                    $input = $field->textInput($options);
                    break;
                case KeyStorageFormModel::TYPE_DROPDOWN:
                    $input = $field->dropDownList($items, $options);
                    break;
                case KeyStorageFormModel::TYPE_CHECKBOX:
                    $input = $field->checkbox($options);
                    break;
                case KeyStorageFormModel::TYPE_CHECKBOXLIST:
                    $input = $field->checkboxList($items, $options);
                    break;
                case KeyStorageFormModel::TYPE_RADIOLIST:
                    $input = $field->radioList($items, $options);
                    break;
                case KeyStorageFormModel::TYPE_TEXTAREA:
                    $input = $field->textarea($options);
                    break;
                case KeyStorageFormModel::TYPE_WIDGET:
                    $widget = ArrayHelper::getValue($config, 'widget');
                    if ($widget === null) {
                        throw new InvalidConfigException('Widget class must be set');
                    }
                    $input = $field->widget($widget, $options);
                    break;
                default:
                    $input = $field->input($type, $options);

            }
            echo $input;
        }
        echo Html::submitButton($this->submitText, $this->submitOptions);
        call_user_func([$this->formClass, 'end']);
    }
}

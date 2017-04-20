<?php

namespace ProcessWire\GraphQL\Field\Traits;

use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\InputField;
use ProcessWire\GraphQL\Type\Scalar\TemplatedSelectorType;

trait OptionalTemplatedSelectorTrait {

  public function build(FieldConfig $config)
  {
    $config->addArgument(new InputField([
      'name' => TemplatedSelectorType::ARGUMENT_NAME,
      'type' => new TemplatedSelectorType($this->template),
    ]));
  }

  public function resolve($value, array $args, ResolveInfo $info)
  {
    if (isset($args[TemplatedSelectorType::ARGUMENT_NAME])) {
      $selector = $args[TemplatedSelectorType::ARGUMENT_NAME];  
    } else {
      $defaultValue = new TemplatedSelectorType($this->template);
      $selector = $defaultValue->serialize("");
    }
    $fieldName = $this->getName();
    $result = $value->$fieldName($selector);
    if ($result instanceof NullPage) return null;
    return $return;
  }

}
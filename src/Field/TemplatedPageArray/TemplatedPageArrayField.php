<?php

namespace ProcessWire\GraphQL\Field\TemplatedPageArray;

use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Field\InputField;

use ProcessWire\Template;
use Processwire\GraphQL\Utils;
use ProcessWire\GraphQL\Type\Object\TemplatedPageArrayType;
use ProcessWire\GraphQL\Type\Scalar\TemplatedSelectorType;

class TemplatedPageArrayField extends AbstractField {

  protected $template;

  public function __construct(Template $template)
  {
    $this->template = $template;
    parent::__construct([]);
  }

  public function getType()
  {
    return new TemplatedPageArrayType($this->template);
  }

  public function getName()
  {
    return TemplatedPageArrayType::normalizeName($this->template->name);
  }

  public function getDescription()
  {
    $desc = $this->template->description;
    if ($desc) return $desc;
    return "PageArray that stores only pages with template `" . $this->template->name . "`.";
  }

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
    
    if (!$value instanceof Pages && !$value instanceof PageArray) {
      $value = Utils::pages();  
    }
    return $value->find($selector);
  }

}
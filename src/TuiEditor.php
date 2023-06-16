<?php

namespace Lyhty\NovaTuiEditor;

use Lyhty\NovaTuiEditor\Enums\EditorType;
use Lyhty\NovaTuiEditor\Enums\PreviewStyle;
use Laravel\Nova\Contracts\Deletable as DeletableContract;
use Laravel\Nova\Contracts\Storable as StorableContract;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\HasAttachments;


class TuiEditor extends Field implements StorableContract, DeletableContract
{
    use HasAttachments;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-tui-editor';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    protected $options;

    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->options = [
            ...config('nova-tui-editor', []),
            'language' => config('nova-tui-editor.language', app()->getLocale()) ?? app()->getLocale(),
        ];
    }

    public function initialEditType(EditorType $type)
    {
        $this->options['initialEditType'] = $type;

        return $this;
    }


    public function minHeight(string $minHeight)
    {
        $this->options['minHeight'] = $minHeight;

        return $this;
    }

    public function language(string $language)
    {
        $this->options['language'] = $language ?? app()->getLocale();

        return $this;
    }

    public function useCommandShortcut(bool $useCommandShortcut = true)
    {
        $this->options['useCommandShortcut'] = $useCommandShortcut;

        return $this;
    }

    public function hideModeSwitch(bool $hideModeSwitch = true)
    {
        $this->options['hideModeSwitch'] = $hideModeSwitch;

        return $this;
    }

    public function toolbarItems(array $toolbarItems)
    {
        $this->options['toolbarItems'] = $toolbarItems;

        return $this;
    }

    public function height(string $height)
    {
        $this->options['height'] = $height;

        return $this;
    }

    public function previewStyle(PreviewStyle $style)
    {
        $this->options['previewStyle'] = $style;

        return $this;
    }

    public function allowIframe(bool $allowIframe = true)
    {
        $this->options['allowIframe'] = $allowIframe;

        return $this;
    }

    public function plugins(array $plugins)
    {
        $this->options['plugins'] = $plugins;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            ...parent::jsonSerialize(),
            'withFiles' => $this->withFiles,
            'editor' => [
                ...$this->options,
                'initialEditType' => $this->options['initialEditType']->value,
                'previewStyle' => $this->options['previewStyle']->value,
                'allowIframe' => $this->options['allowIframe'] === true,
            ],
        ];
    }
}
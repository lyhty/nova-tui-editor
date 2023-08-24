<?php

namespace Lyhty\NovaTuiEditor;

use Closure;
use Lyhty\NovaTuiEditor\Enums\EditorType;
use Lyhty\NovaTuiEditor\Enums\PreviewStyle;
use Laravel\Nova\Contracts\Deletable as DeletableContract;
use Laravel\Nova\Contracts\Storable as StorableContract;
use Laravel\Nova\Fields\Field;
use Laravel\Nova\Fields\HasAttachments;
use Laravel\Nova\Http\Requests\NovaRequest;
use Lyhty\NovaTuiEditor\Enums\EditorPlugin;
use Lyhty\NovaTuiEditor\Enums\EditorToolbarItem;

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

    /**
     * The field's options.
     */
    protected array $options = [];

    /**
     * Create a new field.
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct($name, $attribute, $resolveCallback);

        $this->options = [
            ...config('nova-tui-editor', []),
            'language' => config('nova-tui-editor.language', app()->getLocale()) ?? app()->getLocale(),
        ];
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void|\Closure
     */
    protected function fillAttribute(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        return $this->fillAttributeWithAttachment($request, $requestAttribute, $model, $attribute);
    }

    public function asLyhtyEnhanced($enhanced = true)
    {
        return $this->withMeta(['enhanced' => $enhanced]);
    }

    public function allowFullScreen(bool $allowFullScreen = true)
    {
        $this->options['allowFullScreen'] = $allowFullScreen;

        return $this;
    }

    public function initialEditType(EditorType|Closure|string $type)
    {
        $this->options['initialEditType'] = $type;

        return $this;
    }

    public function previewStyle(PreviewStyle|Closure|string $style)
    {
        $this->options['previewStyle'] = $style;

        return $this;
    }

    public function language(?string $language)
    {
        $this->options['language'] = $language ?: app()->getLocale();

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

    /**
     * @param array<string|EditorPlugin> $plugins
     */
    public function plugins(array $plugins)
    {
        $this->options['plugins'] = $plugins;

        return $this;
    }

    protected function resolvePreviewStyle(): ?string
    {
        $previewStyle = $this->options['previewStyle'] ?? null;

        if ($previewStyle instanceof Closure) {
            $previewStyle = $previewStyle();
        }

        if (is_null($previewStyle)) {
            return null;
        }

        return $previewStyle instanceof PreviewStyle
            ? $previewStyle->value
            : PreviewStyle::from($previewStyle)->value;
    }

    protected function resolveInitialEditType(): ?string
    {
        $initialEditType = $this->options['initialEditType'] ?? null;

        if ($initialEditType instanceof Closure) {
            $initialEditType = $initialEditType();
        }

        if (is_null($initialEditType)) {
            return null;
        }

        return $initialEditType instanceof EditorType
            ? $initialEditType->value
            : EditorType::from($initialEditType)->value;
    }

    /**
     * @return string[][]
     */
    protected function resolveToolbarItems(): array
    {
        $toolbarItems = $this->options['toolbarItems'] ?? [];

        $func = function (EditorToolbarItem|string $item) {
            return is_string($item) ? $item : $item->value;
        };

        return array_map(fn (array $group) => array_map($func, $group), $toolbarItems);
    }

    /**
     * @return string[]
     */
    protected function resolvePlugins(): array
    {
        $plugins = $this->options['plugins'] ?? [];

        return array_map(function (EditorPlugin|string $plugin) {
            return is_string($plugin) ? $plugin : $plugin->value;
        }, $plugins);
    }

    public function jsonSerialize(): array
    {
        return [
            ...parent::jsonSerialize(),
            'withFiles' => $this->withFiles,
            'editor' => [
                ...$this->options,
                'toolbarItems' => $this->resolveToolbarItems(),
                'initialEditType' => $this->resolveInitialEditType(),
                'previewStyle' => $this->resolvePreviewStyle(),
                'plugins' => $this->resolvePlugins(),
            ],
        ];
    }
}

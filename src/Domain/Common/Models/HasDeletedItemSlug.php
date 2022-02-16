<?php

namespace Domain\Common\Models;

/**
 * @see {@link \Domain\Common\Models\HasDeletedItemSlug::getDeletedItemSlugAttribute()}
 * @see {@link \Domain\Common\Models\HasDeletedItemSlug::setDeletedItemSlugAttribute()}
 * @property string|null $deleted_item_slug
 */
trait HasDeletedItemSlug
{
    public function getDeletedItemSlugAttribute(): ?string
    {
        $meta = $this->meta;

        return $meta['deleted_item_slug'];
    }

    public function setDeletedItemSlugAttribute(string $slug): void
    {
        $meta = $this->meta;
        $meta['deleted_item_slug'] = $slug;
        $this->meta = $meta;
    }
}

<?php

namespace Domain\Users\QueryBuilders;

use Domain\Users\Models\BaseUser\BaseUser;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of \Domain\Users\Models\BaseUser\BaseUser
 * @extends Builder<TModelClass>
 *
 * @method \Domain\Users\Models\BaseUser\BaseUser findOrFail($id, $columns = ['*'])
 */
class UserQueryBuilder extends Builder
{
    public function notAdmin(): self
    {
        return $this->where("status", "<", BaseUser::ADMIN_THRESHOLD);
    }
}

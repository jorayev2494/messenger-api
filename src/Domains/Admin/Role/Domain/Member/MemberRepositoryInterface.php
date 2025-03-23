<?php

namespace Project\Domains\Admin\Role\Domain\Member;

use Project\Domains\Admin\Role\Domain\Member\ValueObjects\Uuid;

interface MemberRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Member;

    public function save(Member $member): void;

    public function delete(Member $member): void;
}
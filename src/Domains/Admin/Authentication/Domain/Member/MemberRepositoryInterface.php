<?php

namespace Project\Domains\Admin\Authentication\Domain\Member;

use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Email;
use Project\Domains\Admin\Authentication\Domain\Member\ValueObjects\Uuid;

interface MemberRepositoryInterface
{
    public function findByUuid(Uuid $uuid): ?Member;

    public function findByEmail(Email $email): ?Member;

    public function save(Member $member): void;

    public function delete($member): void;
}
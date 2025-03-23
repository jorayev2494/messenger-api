<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Authentication\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250323102945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_role_members ADD CONSTRAINT FK_802CD5E96FC02232 FOREIGN KEY (role_uuid) REFERENCES admin_roles (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_802CD5E96FC02232 ON admin_role_members (role_uuid)');
        $this->addSql('ALTER TABLE admin_roles ADD is_super_admin TINYINT(1) DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin_role_members DROP FOREIGN KEY FK_802CD5E96FC02232');
        $this->addSql('DROP INDEX IDX_802CD5E96FC02232 ON admin_role_members');
        $this->addSql('ALTER TABLE admin_roles DROP is_super_admin');
    }
}

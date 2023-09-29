<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use App\Entity\User;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928103000 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;

    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $passwordEncoder = $this->container->get('security.password_encoder');
        $encodedPassword = $passwordEncoder->encodePassword(new User(), 'admin123');
        $roles = json_encode(['ROLE_ADMIN', 'ROLE_USER']);
        // Create the sequence if it doesn't exist
        $this->addSql('DO $$ BEGIN CREATE SEQUENCE IF NOT EXISTS user_id_seq; END $$;');

        // Set the default value for the id column from the sequence
        $this->addSql('ALTER TABLE "user" ALTER COLUMN id SET DEFAULT nextval(\'user_id_seq\')');

        // If necessary, set the sequence's next value to the max id from the user table to avoid conflicts
        $this->addSql('SELECT setval(\'user_id_seq\', (SELECT MAX(id) FROM "user"));');

        $this->addSql('INSERT INTO "user" (email, password, roles, balance) VALUES (?, ?, ?, 0)',
            ['admin@example.com', $encodedPassword, $roles]
        );        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ALTER balance DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // Reset the default value
        $this->addSql('ALTER TABLE "user" ALTER COLUMN id DROP DEFAULT');

        // If you wish to drop the sequence as well (only if you're sure it's not used elsewhere)
        $this->addSql('DROP SEQUENCE IF EXISTS user_id_seq');
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" ALTER balance SET DEFAULT 0');
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}

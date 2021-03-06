<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;
use UserBundle\Entity\UserGroup;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160923141633 extends AbstractMigration implements ContainerAwareInterface
{
    private $container;

    private $users = array(
        'admin' =>
        array(
            'username' => 'admin',
            'email' => 'admin@tnqsoft.com',
            'password' => '123456',
        ),
        'user' =>
        array(
            'username' => 'customer',
            'email' => 'customer@tnqsoft.com',
            'password' => '123456',
        ),
    );

    private $roles = array(
        'admin' => array('ROLE_ADMIN'),
        'user' => array('ROLE_USER'),
    );

    private $groups = array(
        'admin' =>
        array(
            'title' => 'Admin',
            'description' => 'Admin Group'
        ),
        'user' =>
        array(
            'title' => 'User',
            'description' => 'User Group'
        ),
    );

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $em = $this->container->get('doctrine.orm.entity_manager');
        $encoder = $this->container->get('security.password_encoder');

        //////////////////////////////////////////////////////////////

        $groupAdmin = new UserGroup();
        $groupAdmin->setTitle($this->groups['admin']['title']);
        $groupAdmin->setDescription($this->groups['admin']['description']);
        $groupAdmin->setRole($this->roles['admin']);
        $em->persist($groupAdmin);

        $groupUser = new UserGroup();
        $groupUser->setTitle($this->groups['user']['title']);
        $groupUser->setDescription($this->groups['user']['description']);
        $groupUser->setRole($this->roles['user']);
        $em->persist($groupUser);

        //////////////////////////////////////////////////////////////

        $user = new User();
        $user->setUsername($this->users['user']['username']);
        $user->setEmail($this->users['user']['email']);
        $user->setGroup($groupUser);
        $encodedPassword = $encoder->encodePassword($user, $this->users['user']['password']);
        $user->setPassword($encodedPassword);
        $user->setResetToken(null);
        $em->persist($user);

        $admin = new User();
        $admin->setUsername($this->users['admin']['username']);
        $admin->setEmail($this->users['admin']['email']);
        $admin->setGroup($groupAdmin);
        $encodedPassword = $encoder->encodePassword($admin, $this->users['admin']['password']);
        $admin->setPassword($encodedPassword);
        $admin->setResetToken(null);
        $em->persist($admin);

        $em->flush();

        $this->addSql('SELECT 1');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DELETE FROM `user`');
        $this->addSql('DELETE FROM `user_group`');
    }
}

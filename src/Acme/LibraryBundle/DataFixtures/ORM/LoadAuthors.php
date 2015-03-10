<?php
namespace Acme\LibraryBundle\DataFixtures\ORM;

use Acme\LibraryBundle\Entity\Author;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class LoadAuthors implements FixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @inheritdoc
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    /**
     * @inheritdoc
     */
    function load(ObjectManager $manager)
    {
        $fileName = 'authors.json';
        $rootDir = $this->container->get('kernel')->getRootDir();
        $path = $rootDir . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $fileName;
        if(!is_file($path)) {
            throw new FileException($fileName . " не найден.");
        }
        $authors = file_get_contents($path);
        $authors = json_decode($authors, true);
        foreach($authors as $author) {
            $model = new Author();
            $model->setName($author['name']);
            $model->setBirthday(new \DateTime($author['birthday']));
            $model->setDescription($author['description']);
            $manager->persist($model);
        }

        $manager->flush();

    }

} 
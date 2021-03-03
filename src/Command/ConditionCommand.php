<?php

namespace App\Command;

use App\Entity\Rules\Condition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ConditionCommand extends Command
{
    private $em;

    private $translator;

    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator, ?string $name = null)
    {
        parent::__construct($name);
        $this->em     = $em;
        $this->translator = $translator;
    }

    protected function configure()
    {
        $this
            ->setName('pathfinder:conditions:create')
            ->setDescription('Create ability-based conditions');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach (['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'] as $ability) {
            for ($i = -1; $i >= -10; $i--) {
                $condition = new Condition();
                $condition->setEffects([$ability => ['type' => null, 'value' => $i]]);
                $condition
                    ->translate('en')
                    ->setName(
                        $i.' '.
                        ucfirst($this->translator->trans($ability, [], null, 'en'))
                    );
                $condition
                    ->translate('fr')
                    ->setName(
                        $i.' '.
                        ucfirst($this->translator->trans($ability, [], null, 'fr'))
                    );

                $this->em->persist($condition);
                $condition->mergeNewTranslations();
            }
        }
        $this->em->flush();

        return 0;
    }
}

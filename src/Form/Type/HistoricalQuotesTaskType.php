<?php declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Listing;
use App\Repository\ListingRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType as AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface as FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class HistoricalQuotesTaskType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('listing', EntityType::class, [
                'class'         => Listing::class,
                'query_builder' => function (ListingRepository $lr) {
                    return $lr->createQueryBuilder('l')
                        ->orderBy('l.symbol', 'ASC');
                },
                'choice_label'  => 'symbol',
            ])
            ->add('dateFrom', DateType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Date(),
                        new LessThanOrEqual((new \DateTimeImmutable())->format('Y-m-d'))
                    ],
                    'widget' => 'single_text',
                    'data' => (new \DateTime("now"))->modify('- 1 month'),
        ])
            ->add('dateTo', DateType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Date(),
                        new LessThanOrEqual((new \DateTimeImmutable())->format('Y-m-d'))
                    ],
                    'widget' => 'single_text',
                    'data' => new \DateTime("now"),
                ])
            ->add('email', EmailType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Email(),
                    ]
                ])
            ->add('save', SubmitType::class, ['label' => 'Create Task']);
    }
}

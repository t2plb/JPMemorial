<?php


namespace GestProd\Badgester\API;

use App\API\APIController;
use App\Service\APISerialize;
use App\Service\Security;
use Doctrine\Persistence\ManagerRegistry;
use GestProd\Badgester\Entity\User;
use GestProd\Badgester\Repository\UserRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[
    Route('/user', name: 'user'),
    OA\Tag(name: 'Badgester'),
    OA\Response(
        response: 400,
        description: 'Missing parameter'
    ),
    OA\Response(
        response: 406,
        description: 'User not found'
    )
]
class UserAPI extends APIController
{
    public function __construct(APISerialize $APISerialize, Security $security, ManagerRegistry $doctrine)
    {
        parent::__construct($APISerialize, $security, $doctrine);
    }


    #[
        Route('', name: 'get', methods: ['GET']),
        OA\Response(
            response: 200,
            description: 'Successful response',
            content: new Model(type: User::class)
        ),
        OA\Parameter(
            name: 'id',
            description: 'User id',
            in: 'query',
            schema: new OA\Schema(type: 'integer')
        ),
    ]
    public function getEntity(Request $request, UserRepository $users): Response
    {
        if ($this->security->ArrayHasNoEmptyValue([
            $request->query->get('id')
        ])) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $user = $users->find($request->query->get('id'));
        if ($user == null) {
            return new Response('', Response::HTTP_NOT_ACCEPTABLE);
        }

        return $this->APISerialize->serialize($user);
    }

    #[
        Route('', name: 'create', methods: ['POST']),
        OA\Response(
            response: 200,
            description: 'Successful response',
            content: new Model(type: User::class)
        ),
        OA\Parameter(
            name: 'Matricule',
            description: 'User matricule',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
        OA\Parameter(
            name: 'Badge',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'string', pattern: '/[a-z\d]{8}/g')
        ),
        OA\Parameter(
            name: 'GlobalLevel',
            description: 'Global level on all machines',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'integer', maximum: 5, minimum: 0)
        ),
        OA\Parameter(
            name: 'Enabled',
            description: 'Set status, default : true',
            in: 'query',
            schema: new OA\Schema(type: 'boolean', maximum: 5, minimum: 0)
        ),
    ]
    public function create(Request $request, UserRepository $users): Response
    {
        if ($this->security->ArrayHasNoEmptyValue([
            $request->query->get('Matricule'),
            $request->query->get('Badge'),
            $request->query->get('GlobalLevel'),
        ])) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $user = new User();
        $user
            ->setMatricule($request->query->get('Matricule'))
            ->setBadge(strtolower($request->query->get('Badge')))
            ->setGlobalLevel($request->query->get('GlobalLevel'));

        if (!$this->security->ArrayHasNoEmptyValue([
            $request->query->get('Enabled')
        ])) {
            $user->setEnabled($request->query->get('Enabled'));
        }

        $users->add($user, true);

        return $this->APISerialize->serialize($user);
    }

    #[
        Route('', name: 'update', methods: ['PUT']),
        OA\Response(
            response: 200,
            description: 'Successful response',
        ),
        OA\Parameter(
            name: 'id',
            description: 'Entity id',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
        OA\Parameter(
            name: 'Matricule',
            description: 'User matricule',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'integer')
        ),
        OA\Parameter(
            name: 'Badge',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'string', pattern: '/[a-z\d]{8}/g')
        ),
        OA\Parameter(
            name: 'GlobalLevel',
            description: 'Global level on all machines',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'integer', maximum: 5, minimum: 0)
        ),
        OA\Parameter(
            name: 'Enabled',
            description: 'Set status, default : true',
            in: 'query',
            required: true,
            schema: new OA\Schema(type: 'boolean')
        ),
    ]
    public function update(Request $request, UserRepository $users): Response
    {
        if ($this->security->ArrayHasNoEmptyValue([
            $request->query->get('id'),
            $request->query->get('Matricule'),
            $request->query->get('Badge'),
            $request->query->get('GlobalLevel'),
            $request->query->get('Enabled'),
        ])) {
            return new Response('', Response::HTTP_BAD_REQUEST);
        }

        $user = $users->find($request->query->get('id'));
        if ($user == null) {
            return new Response('', Response::HTTP_NOT_ACCEPTABLE);
        }
        $user
            ->setMatricule($request->query->get('Matricule'))
            ->setBadge(strtolower($request->query->get('Badge')))
            ->setGlobalLevel($request->query->get('GlobalLevel'))
            ->setEnabled($request->query->get('GlobalLevel'));
        $users->add($user, true);

        return new Response('', Response::HTTP_OK);
    }
}
?>
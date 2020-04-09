<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Restaurant;
use App\Entity\Menuitem;


class PanelController extends AbstractController
{

    /**
     * @Route("/panel", methods={"GET"}, name="app_panel_index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $this->getUser()->getEmail()]);
        $openedTab = $request->query->get('opened_tab') ?: null;
        $success = $request->query->get('success') ?: null;
        $error = $request->query->get('error') ?: null;
        return $this->render('panel/index.html.twig', [
            'opened_tab' => $openedTab,
            'success' => $success,
            'error' => $error,
            'cuisines' => $this->getDoctrine()->getRepository('App\Entity\Cuisine')->findAll(),
            'menuitems' => $userObj->getRestaurantId() ? $this->getDoctrine()->getRepository('App\Entity\Menuitem')->findBy(['restaurantid' => $userObj->getRestaurantId()->getId()]) : null
        ]);
    }


    /**
     * @Route("/panel/processrestaurant", methods={"POST"}, name="app_edit_restaurant_process")
     * @param Request $request
     * @return Response
     */
    public function processUserRestaurant(Request $request)
    {
        $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $this->getUser()->getEmail()]);
        $restaurant = $userObj->getRestaurantId();
        $cuisineObj = $this->getDoctrine()->getRepository('App\Entity\Cuisine')->findOneBy(['id' => $request->request->get('cuisine')]);

        $restaurant->setName($request->request->get('restaurantName'));
        $restaurant->setImage($request->request->get('imageLink'));
        $restaurant->setCuisineid($cuisineObj);
        $restaurant->setEmail($this->getUser()->getEmail());
        $restaurant->setLng($request->request->get('lng'));
        $restaurant->setLat($request->request->get('lat'));
        $restaurant->setDeliverytime($request->request->get('deliveryTime'));
        $restaurant->setDeliverycost($request->request->get('deliveryCost'));
        $restaurant->setMinimalorder($request->request->get('minimalOrder'));
        $restaurant->setWebsite($request->request->get('website'));
        $restaurant->setEmail($request->request->get('email'));
        $restaurant->setMobile($request->request->get('mobile'));
        $restaurant->setActualdistance(0);
        $restaurant->setOwnerid($userObj->getId());

        $this->getDoctrine()->getManager()->merge($restaurant);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('app_panel_index', [
            'opened_tab' => 'restaurant_details',
            'success' => 'Restaurant details has been changed!'
        ]);
    }

    /**
     * @Route("/panel/deleterestaurant", methods={"POST"}, name="app_panel_delete_restaurant")
     * @param Request $request
     * @return Response
     */
    public function deleteUserRestaurant(Request $request)
    {
        $successMsg = '';
        $errorMsg = '';
        $restaurantID = (int)$request->request->get('restaurantID');
        if ($restaurantID) {
            $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $this->getUser()->getEmail()]);
            if ($userObj->getRestaurantId()->getId() === $restaurantID) {
                $restaurantObj = $this->getDoctrine()->getRepository('App\Entity\Restaurant')->findOneBy(['id' => $restaurantID]);
                $this->getDoctrine()->getManager()->remove($restaurantObj);
                $userObj->setRestaurantId(null);
                $this->getDoctrine()->getManager()->flush();
                $successMsg = 'Restaurant has been deleted successfully';
            } else {
                $errorMsg = 'It seems that this restaurant doesnt belongs to you...';
            }
        } else {
            $errorMsg = 'Restaurant cannot be found...';
        }
        return $this->redirectToRoute('app_panel_index', [
            'opened_tab' => 'restaurant_details',
            'success' => $successMsg,
            'error' => $errorMsg
        ]);
    }

    /**
     * @Route("/panel/editrestaurant", methods={"GET"}, name="app_panel_edit_restaurant")
     * @param Request $request
     * @return Response
     */
    public function editUserRestaurant(Request $request)
    {
        return $this->render('panel/edit_restaurant.html.twig', [
            'cuisines' => $this->getDoctrine()->getRepository('App\Entity\Cuisine')->findAll()
        ]);
    }

    /**
     * @Route("/panel/addrestaurant", methods={"POST"}, name="app_panel_add_restaurant")
     * @param Request $request
     * @return Response
     */
    public function addUserRestaurant(Request $request)
    {
        $cuisineID = $request->request->get('cuisine');
        $cuisineObj = $this->getDoctrine()->getRepository('App\Entity\Cuisine')->findOneBy(['id' => $cuisineID]);
        $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $this->getUser()->getEmail()]);

        $restaurant = new Restaurant();
        $restaurant->setName($request->request->get('restaurantName'));
        $restaurant->setImage($request->request->get('imageLink'));
        $restaurant->setCuisineid($cuisineObj);
        $restaurant->setEmail($this->getUser()->getEmail());
        $restaurant->setLng($request->request->get('lng'));
        $restaurant->setLat($request->request->get('lat'));
        $restaurant->setDeliverytime($request->request->get('deliveryTime'));
        $restaurant->setDeliverycost($request->request->get('deliveryCost'));
        $restaurant->setMinimalorder($request->request->get('minimalOrder'));
        $restaurant->setWebsite($request->request->get('website'));
        $restaurant->setEmail($request->request->get('email'));
        $restaurant->setMobile($request->request->get('mobile'));
        $restaurant->setActualdistance(0);
        $restaurant->setOwnerid($userObj->getId());

        $this->getDoctrine()->getManager()->persist($restaurant);
        $this->getDoctrine()->getManager()->flush();

        $restaurant = $this->getDoctrine()->getRepository('App\Entity\Restaurant')->findOneBy(['ownerid' => $userObj->getId()]);

        $userObj->setRestaurantId($restaurant);
        $this->getDoctrine()->getManager()->persist($userObj);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('app_panel_index', [
            'opened_tab' => 'restaurant_details',
            'success' => 'Restaurant has been added!'
        ]);
    }

    /**
     * @Route("/panel/editprofile", methods={"GET"}, name="app_edit_profile")
     */
    public function editProfile()
    {
        return $this->render('panel/edit_profile.html.twig');
    }

    /**
     * @Route("/panel/processprofile", methods={"POST"}, name="app_edit_profile_process")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function processProfile(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $userName = $request->request->get('email');
        $actualPassword = $request->request->get('password');
        $newPassword = $request->request->get('newpassword1');
        $newPassword2 = $request->request->get('newpassword2');
        $hasRestaurant = $request->request->get('restaurantowner');
        $userObj = $this->getDoctrine()->getManager()->getRepository('App\Entity\User')->findOneBy(['email' => $userName]);

        $errorMsg = '';
        $successMsg = '';
        if ($userName && $actualPassword && $userObj) {
            if ($userName === $this->getUser()->getEmail()) {
                if ($passwordEncoder->isPasswordValid($this->getUser(), $actualPassword)) {
                    if ($newPassword && $newPassword2) {
                        if ($newPassword === $newPassword2) {
                            $userObj->setPassword($passwordEncoder->encodePassword($this->getUser(), $newPassword));
                        } else {
                            $errorMsg = 'New passwords doesnt match!';
                        }
                    }
                    if ($hasRestaurant === 0) {
                        $userObj->setHasRestaurant('');
                    } else {
                        $userObj->setHasRestaurant(1);
                    }

                    $this->getDoctrine()->getManager()->merge($userObj);
                    $this->getDoctrine()->getManager()->flush();
                    if (!$errorMsg) {
                        $successMsg = 'Your profile has been updated successfully!';
                    }
                } else {
                    $errorMsg = 'You wrote wrong password to your account!';
                }
            } else {
                $errorMsg = 'User ID does not match with requested one!';
            }
        }

        return $this->redirectToRoute('app_panel_index', [
            'opened_tab' => 'profile',
            'error' => $errorMsg,
            'success' => $successMsg
        ]);
    }

    /**
     * @Route("/panel/addRestaurantToFav", methods={"POST"}, name="app_panel_add_favorite")
     * @param Request $request
     * @return Response
     */
    public function addRestaurantToFavorites(Request $request)
    {
        $restaurantID = (int)$request->get('restaurantID');
        $openedTab = $request->get('opened_tab') ?: null;
        $user = $this->getUser();
        $errorMsg = [];

        if ($restaurantID && $user) {
            $userEmail = $user->getEmail();
            $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $userEmail]);
            $restaurantObj = $this->getDoctrine()->getRepository('App\Entity\Restaurant')->findOneBy(['id' => $restaurantID]);

            $userFavRestaurants = $userObj->getFavRestaurants();
            $hasAlreadyFav = false;
            foreach ($userFavRestaurants as $userFavRestaurant) {
                if ($userFavRestaurant->getId() === $restaurantObj->getId()) {
                    $hasAlreadyFav = true;
                }
            }

            if ($userObj && $restaurantObj && !$hasAlreadyFav) {
                $userObj->addFavRestaurant($restaurantObj);
                $this->getDoctrine()->getManager()->merge($userObj);
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('app_panel_index', ['opened_tab' => $openedTab]);
            }

            if (!$userObj) $errorMsg[] = 'Cant find user obj, with a given email: ' . $user->getEmail();
            if (!$restaurantObj) $errorMsg[] = 'Cant find restaurant with given ID: ' . $restaurantID;
            if ($hasAlreadyFav) $errorMsg[] = 'You have this restaurant already in your favorites!';

        }
        return $this->redirectToRoute('app_panel_index', [
            'opened_tab' => 'fav',
            'restaurantID' => $restaurantID,
            'error' => $errorMsg,
        ]);
    }

    /**
     * @Route("/panel/deleteFavRestaurant", methods={"POST"}, name="app_panel_delete_favorite")
     * @param Request $request
     * @return Response
     */
    public function deleteRestaurantFromFavorites(Request $request)
    {
        $restaurantID = (int)$request->request->get('restaurantID');
        $userEmail = $this->getUser()->getEmail();
        $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $userEmail]);

        $successMsg = null;
        $errorMsg = 'You do not have this restaurant in your favorites!';

        if ($restaurantID && $userEmail && $userObj) {
            $userFavRestaurants = $userObj->getFavRestaurants();
            for ($i = 0, $iMax = count($userFavRestaurants); $i < $iMax; $i++) {
                if ($userFavRestaurants[$i]->getId() === $restaurantID) {
                    unset($userFavRestaurants[$i]);
                    $successMsg = 'Restaurant has been removed from favorites!';
                    $errorMsg = null;
                }
            }

            $userObj->setFavRestaurants($userFavRestaurants);
            $this->getDoctrine()->getManager()->merge($userObj);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('app_panel_index', [
                'opened_tab' => 'fav',
                'success' => $successMsg,
                'error' => $errorMsg
            ]);

        } else {
            return $this->redirectToRoute('app_panel_index', [
                'opened_tab' => 'fav',
                'error' => 'You do not have this restaurant in your favorites!',
            ]);
        }
    }

    /**
     * @Route("/panel/addMenuItem", methods={"GET"}, name="app_panel_add_menuitem")
     * @param Request $request
     * @return Response
     */
    public function addMenuItem(Request $request)
    {
        return $this->render('panel/add_menu_item.html.twig');
    }

    /**
     * @Route("/panel/editMenuItem", methods={"POST"}, name="app_panel_edit_menuitem")
     * @param Request $request
     * @return Response
     */
    public function editMenuItem(Request $request)
    {
        $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $this->getUser()->getEmail()]);
        $restaurantID = $userObj->getRestaurantId()->getId();
        $menuItemID = (int)$request->request->get('menu_item_id');
        $menuItemObj = null;

        if ($restaurantID && $menuItemID) {
            $menuItemObj = $this->getDoctrine()->getRepository('App\Entity\Menuitem')->findOneBy(['id' => $menuItemID]);
            if ($menuItemObj) {
                if (!$menuItemObj->getRestaurantid() === $restaurantID) {
                    $menuItemObj = null;
                }
            } else {
                $errorMsg = 'Menu item with ID: ' . $menuItemID . ' doesnt exists!';
            }
        } else {
            $errorMsg = 'You dont have restaurant, add restaurant first!';
        }

        return $this->render('panel/edit_menu_item.html.twig', [
            'menuitem' => $menuItemObj
        ]);
    }

    /**
     * @Route("/panel/editMenuItemProcess", methods={"POST"}, name="app_panel_edit_menuitem_process")
     * @param Request $request
     * @return Response
     */
    public function editMenuItemProcess(Request $request)
    {
        $successMsg = '';
        $errorMsg = '';

        $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $this->getUser()->getEmail()]);
        $restaurantID = $userObj->getRestaurantId()->getId();
        $menuItemID = (int)$request->request->get('mealID');

        if ($restaurantID && $menuItemID) {
            $menuItemObj = $this->getDoctrine()->getRepository('App\Entity\Menuitem')->findOneBy(['id' => $menuItemID]);
            if ($menuItemObj) {
                if ($menuItemObj->getRestaurantid() === $restaurantID) {
                    $menuItemObj->setName($request->request->get('mealName'));
                    $menuItemObj->setIngredients($request->request->get('ingredients'));
                    $menuItemObj->setPrice((float)$request->request->get('price'));

                    $this->getDoctrine()->getManager()->merge($menuItemObj);
                    $this->getDoctrine()->getManager()->flush();

                    $successMsg = 'Your menu item has been saved successfully';

                } else {
                    $errorMsg = 'It seems that you are not the owner of menu item with ID: ' . $menuItemID;
                }
            } else {
                $errorMsg = 'Menu item with ID: ' . $menuItemID . ' doesnt exists!';
            }
        } else {
            $errorMsg = 'You dont have restaurant, add restaurant first!';
        }

        return $this->redirectToRoute('app_panel_index', [
            'opened_tab' => 'restaurant_menu',
            'error' => $errorMsg,
            'success' => $successMsg,
            'cuisines' => $this->getDoctrine()->getRepository('App\Entity\Cuisine')->findAll(),
            'menuitems' => $this->getDoctrine()->getRepository('App\Entity\Menuitem')->findBy(['restaurantid' => $userObj->getRestaurantId()->getId()])
        ]);
    }

    /**
     * @Route("/panel/addMenuItemProcess", methods={"POST"}, name="app_panel_add_menuitem_process")
     * @param Request $request
     * @return Response
     */
    public function addMenuItemProcess(Request $request)
    {
        $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $this->getUser()->getEmail()]);
        $errorMsg = '';
        $successMsg = '';

        $mealName = $request->request->get('mealName');
        $ingredients = $request->request->get('ingredients');
        $price = (float)$request->request->get('price');

        if ($mealName && $ingredients && $price && $userObj) {
            $menuItem = new Menuitem();
            $menuItem->setName($mealName);
            $menuItem->setIngredients($ingredients);
            $menuItem->setPrice($price);
            $menuItem->setRestaurantid($userObj->getRestaurantId()->getId());

            $this->getDoctrine()->getManager()->persist($menuItem);
            $this->getDoctrine()->getManager()->flush();
            $successMsg = 'Item has been added successfully';
        } else {
            $errorMsg = 'Your are missing parameters. Please fill out every field in menu item';
        }
        return $this->redirectToRoute('app_panel_index', [
            'opened_tab' => 'restaurant_menu',
            'success' => $successMsg,
            'error' => $errorMsg
        ]);
    }

    /**
     * @Route("/panel/deleteMenuItem", methods={"POST"}, name="app_panel_delete_menuitem")
     * @param Request $request
     * @return Response
     */
    public function deleteMenuItem(Request $request)
    {
        $successMsg = '';
        $errorMsg = '';

        $userObj = $this->getDoctrine()->getRepository('App\Entity\User')->findOneBy(['email' => $this->getUser()->getEmail()]);
        $restaurantID = $userObj->getRestaurantId()->getId();
        $menuItemID = (int)$request->request->get('menu_item_id');

        if ($restaurantID && $menuItemID) {
            $menuItemObj = $this->getDoctrine()->getRepository('App\Entity\Menuitem')->findOneBy(['id' => $menuItemID]);
            if ($menuItemObj) {
                if ($menuItemObj->getRestaurantid() === $restaurantID) {
                    $this->getDoctrine()->getManager()->remove($menuItemObj);
                    $this->getDoctrine()->getManager()->flush();

                    $successMsg = 'Your menu item has been deleted successfully';

                } else {
                    $errorMsg = 'It seems that you are not the owner of menu item with ID: ' . $menuItemID;
                }
            } else {
                $errorMsg = 'Menu item with ID: ' . $menuItemID . ' doesnt exists!';
            }
        } else {
            $errorMsg = 'You dont have restaurant, add restaurant first!';
        }

        return $this->redirectToRoute('app_panel_index', [
            'opened_tab' => 'restaurant_menu',
            'error' => $errorMsg,
            'success' => $successMsg,
        ], 307);
    }

}
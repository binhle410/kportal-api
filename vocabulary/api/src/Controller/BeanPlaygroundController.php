<?php

namespace App\Controller;

use App\Entity\Entry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BeanPlaygroundController extends AbstractController
{
    /**
     * @Route("/bean/playground", name="bean_playground")
     */
    public function index()
    {
        $data = Entry::fetch('ENTRY-20190531160418-821-5cf1508260e14', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE1NTkzODU4NDYsImV4cCI6MTU1OTM4OTQ0Niwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInV1aWQiOiJVU0VSLTIwMTkwNTMxMTYwNDE4LTgyMS01Y2YxNTA4MjYwZTE0IiwiaXAiOiIxMC4wLjIuMiIsInBlcnNvbiI6IlBFUlNPTi0yMDE5MDUzMTE2MDQxOC04MjEtNWNmMTUwODI2MGUxNCIsIm9yZyI6Ik9SRy01ZGQzYzBiYTAwZjQwLTEwMzgyNzA0MjAxOSIsImltIjoiT1JHX0lNXzFfMS01ZGQzYzBiYTAwZjQwLTEwMzgyNzA0MjAxOSJ9.h8ZGl3hLySb2VnKPKuFZmt6BzE8vFy4nIbC0j6G2qX8Pp3QdysG_D_P2YJPIHLZnxN3Zih13T83ZgdU4VY5Ofl4w0-E6th9YRQOvv8XeAacKmxVmj4fhG3TI3na8o7IXqxPpAhr245alJ0y6zoqt5sL6E8BEtIHuU0Rv-s5cXc9ZgBBqQJKwBMB_z4CtmN5oO-b4zJXI5WOSqFxTyV7YoB1Mibge-WDis4DwcQ6C5__GlPee7l_tpwVOCSPzx4jZ6IyBUZXWmzLufxlAtVqIr0fsJy_gL7GrXyULI3eYykkGB5zVmIi1h2ac6waZ5xoJzCNNy6NXaYndzhwt-IKadZYHWZSrTdYTGH0cvaZSTeaLNJZ2_naqH2Ntca_tA02-h2hqjF3-6FYYRyuiGoeGHSoxnEcC6g7szW3UMnactHKhWDI9igAu9BiE5ODBABqxA29ANW3nXXQ7PYxlJl1Vf_dXRA8nQQhEBMva6nG7PxeTQmrYcxyMASbVs4O3Rtyzd2Z6GvOzxjmALpnaMKlMo80XudmZxrHaDrokRUTgoX9152YjllneoYjGzYronE48KiCjmTQlJywZkXJqA9hSxwXKHU4esvb1CSnQEzyDC8b6Lk9dX9ioowZ44ox9AghW_3MIY-HoTO8KXV_eKGdDlbpF0wRu_vvrfr_ypR4cdVg');

        return $this->render('bean_playground/index.html.twig', [
            'controller_name' => 'BeanPlaygroundController',
            'data' => $data
        ]);
    }
}

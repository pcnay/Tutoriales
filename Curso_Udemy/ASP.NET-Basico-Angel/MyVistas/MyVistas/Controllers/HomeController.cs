using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace MyVistas.Controllers
{
    public class HomeController : Controller
    {
        // GET: Home
        public ActionResult Index()
        {
            return View();
        }
        /* Para llamar este método de acción desde el navegador, escribir :
            http://local.../Home/Controlador             */
        public string MiControlador()
        {
            return "Este es mi controlador";
        }

        public ActionResult MiVista()
        {
            return View();
        }  
    }
}
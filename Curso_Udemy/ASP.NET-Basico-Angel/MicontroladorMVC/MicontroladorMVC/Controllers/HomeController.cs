using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace MicontroladorMVC.Controllers
{
    public class HomeController : Controller
    {
        // GET: Home
        public ActionResult Index()
        {
            return RedirectToAction("TodosLosProveedores", "proveedores");
            /* TodosLosProveedores = Es un método de acción.
                En lugar de desplegar la línea anterior se redirige al controlador "Proveedores" y método de acción "TodosLosProveedores" 
             */
            /* "Este es mi controlador Home";*/
        }
    }
}
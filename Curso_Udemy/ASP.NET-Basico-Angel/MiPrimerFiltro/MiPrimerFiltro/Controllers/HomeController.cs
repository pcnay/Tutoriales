using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace MiPrimerFiltro.Controllers
{
    public class HomeController : Controller
    {
        /* [Authorize] */
        // GET: Home
        public string Index()
        {
            return "Este es un controlador Home";
        }


        /*
        /* Quien tiene permitido ejecutar el método de acción "HoraActual" 
        [Authorize (Roles ="Admin")]

        /* Aplicando el filtro "outputcache" mantiene por 10 seg. en el cache la hora sin modificarse
        [OutputCache (Duration = 10)]
        */

        /* Renombrando al método acción a nombre de Hora  */
        [ActionName("Hora")]
        public string HoraActual()
        {
            return CadenaHora();
        }


        /* NO funcionara como método acción */
        [NonAction]
        public string CadenaHora()
        {
            return "Son las "+DateTime.Now.ToString("T");
        }
    }
}
using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;

namespace MicontroladorMVC.Controllers
{
    public class ClientesController : Controller
    {
        // GET: Clientes
        public ActionResult Buscar(string nombre)
        {
            var input = Server.HtmlEncode(nombre); /* Lo convierte a texto plano, para poderlo mostrar por pantalla */
            return Content(input);
        }
        /* Lo identifica de la otra función, ya que se le indica cual es el atributo cabecera.
         cuando se escribe por la URL es de forma "GET"*/
        [HttpGet]
        public ActionResult Buscar()
        {
            var input = "Este es un selector HTTP Get";
            return Content (input);
        }

    }
}
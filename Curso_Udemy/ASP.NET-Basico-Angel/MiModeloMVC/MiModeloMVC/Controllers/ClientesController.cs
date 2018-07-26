using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using MiModeloMVC.Models;


namespace MiModeloMVC.Controllers
{
    public class ClientesController : Controller
    {
		public static List<Clientes> empList = new List<Clientes>{

							new Clientes
							{
								ID = 1,
								nombre = "Angel",
								FechaAlta = DateTime.Parse(DateTime.Today.ToString()),
								edad = 30
							},
							new Clientes
							{
								ID = 2,
								nombre = "Patricia",
								FechaAlta = DateTime.Parse(DateTime.Today.ToString()),
								edad = 45
							},

					 };				

        // GET: Clientes
        public ActionResult Index()
        {
            var Clientes = from e in empList
                           orderby e.ID
                           select e;
            return View(Clientes);
        }

        // GET: Clientes/Details/5
        public ActionResult Details(int id)
        {
            return View();
        }

        // GET: Clientes/Create
        public ActionResult Create()
        {
            return View();
        }

        // POST: Clientes/Create
        // Para utilizar el modelo "Binding", se realiza cambios en la función Create
        // Create (FormCollection Collection) por 
        [HttpPost]
        public ActionResult Create(Clientes emp)
        {
            try
            {
              // TODO: Add insert logic here
              // No se requiere la conversion de tipos para poderlos grabar a los registros.
              empList.Add(emp);                                
              

              return RedirectToAction("Index");

            }
            catch
            {
                return View();
            }
        }
				
				// Esta funciones se agregaron cuando se creo el MVC pero con la opción "MVC read/write"
				// Por defecto viene con entrada de datos "GET"
        // GET: Clientes/Edit/5
        public ActionResult Edit(int id)
        {
					List<Clientes> empList = TodosLosClientes();
					var Clientes = empList.Single(m => m.ID == id);
					return View(Clientes);

        }

        // POST: Clientes/Edit/5
        [HttpPost]
        public ActionResult Edit(int id, FormCollection collection)
        {
            try
            {
              // TODO: Add update logic here
              var Clientes = empList.Single(m => m.ID == id);

              if (TryUpdateModel(Clientes))
                return RedirectToAction("Index");

              return View(Clientes);
        
            }
            catch
            {
                return View();
            }
        }

        // GET: Clientes/Delete/5
        public ActionResult Delete(int id)
        {
            return View();
        }

        // POST: Clientes/Delete/5
        [HttpPost]
        public ActionResult Delete(int id, FormCollection collection)
        {
          try
          {
        // TODO: Add delete logic here
        return RedirectToAction("Index");
			    }
			    catch
			    {
				    return View();
			    }
        }

        [NonAction] //  No se puede accesar desde la URL
        public List<Clientes> TodosLosClientes()
        {
            return new List<Clientes>
            {
                new Clientes
                {
                    ID = 1,
                    nombre = "Ramon",
                    /* Fecha, Hora actual cuando se dio de alta.*/ 
                    FechaAlta = DateTime.Parse(DateTime.Today.ToString()),
                    edad = 30
                },
                new Clientes
                {
                    ID = 2,
                    nombre = "Raul",
                    /* Fecha, Hora actual cuando se dio de alta.*/ 
                    FechaAlta = DateTime.Parse(DateTime.Today.ToString()),
                    edad = 45
                },

            };

        } /* public List<Clientes> TodosLosClientes() */

    }
}

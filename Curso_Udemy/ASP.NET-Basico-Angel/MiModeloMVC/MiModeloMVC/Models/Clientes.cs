using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace MiModeloMVC.Models
{
    public class Clientes
    {
        public int ID { get; set; }
        public string nombre { get; set; }
        public DateTime FechaAlta { get; set; }
        public int edad { get; set; }
    }
}

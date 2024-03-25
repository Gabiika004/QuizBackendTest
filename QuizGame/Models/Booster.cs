using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace QuizGame.Models
{
    internal class Booster
    {
            public int Id { get; set; }

            [JsonProperty("boostername")] 
            public string BoosterName { get; set; }

            [JsonProperty("reset_on_new_game")] 
            public bool resetOnNewGame {  get; set; }
    }
}

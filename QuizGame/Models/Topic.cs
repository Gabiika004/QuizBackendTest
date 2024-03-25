using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace QuizGame.Models
{
    public class Topic
    {
        public int Id { get; set; }

        [JsonProperty("topicname")]
        public string TopicName { get; set; }
    }
}

using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace QuizGame.Models
{
    public class Answer
    {
        public int Id { get; set; }
        public int QuestionId { get; set; }

        [JsonProperty("answer_text")]
        public string AnswerText { get; set; }

        [JsonProperty("is_correct")]
        public bool IsCorrect { get; set; }
    }
}


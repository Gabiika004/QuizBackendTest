﻿// <auto-generated />
//
// To parse this JSON data, add NuGet 'Newtonsoft.Json' then do:
//
//    using  QuizGame.Models;
//
//    var userBooster = UserBooster.FromJson(jsonString);

namespace QuizGame.Models
{
    using System;
    using System.Collections.Generic;
    using System.Globalization;
    using Newtonsoft.Json;
    using Newtonsoft.Json.Converters;

    public partial class UserBooster
    {
        [JsonProperty("id")]
        public long Id { get; set; }

        [JsonProperty("userid")]
        public long Userid { get; set; }

        [JsonProperty("boosterid")]
        public long Boosterid { get; set; }

        [JsonProperty("used")]
        public bool Used { get; set; }

        [JsonProperty("created_at")]
        public DateTimeOffset CreatedAt { get; set; }

        [JsonProperty("updated_at")]
        public DateTimeOffset UpdatedAt { get; set; }

        [JsonProperty("booster")]
        public Booster Booster { get; set; }
    }


    public partial class UserBooster
    {
        public static UserBooster[] FromJson(string json) => JsonConvert.DeserializeObject<UserBooster[]>(json, QuizGame.Models.Converter.Settings);
    }

    public static class Serialize
    {
        public static string ToJson(this UserBooster[] self) => JsonConvert.SerializeObject(self, QuizGame.Models.Converter.Settings);
    }

    internal static class Converter
    {
        public static readonly JsonSerializerSettings Settings = new JsonSerializerSettings
        {
            MetadataPropertyHandling = MetadataPropertyHandling.Ignore,
            DateParseHandling = DateParseHandling.None,
            Converters =
            {
                new IsoDateTimeConverter { DateTimeStyles = DateTimeStyles.AssumeUniversal }
            },
        };
    }
}

using System.Net.Http;
using System.Threading.Tasks;
using System.Collections.Generic;
using Newtonsoft.Json;
using QuizGame.Models;

public class QuizApiService
{
    private readonly HttpClient _httpClient;
    private readonly string _baseUrl = "http://127.0.0.1:8000/api"; // Cseréld le a saját URL-edre

    public QuizApiService()
    {
        _httpClient = new HttpClient();
    }

    public async Task<List<Question>> GetQuestionsAsync()
    {
        var response = await _httpClient.GetAsync($"{_baseUrl}/questions");
        if (response.IsSuccessStatusCode)
        {
            var content = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<List<Question>>(content);
        }
        return null;
    }

    public async Task<List<Topic>> GetTopicsAsync()
    {
        var response = await _httpClient.GetAsync($"{_baseUrl}/topics");
        if (response.IsSuccessStatusCode)
        {
            var content = await response.Content.ReadAsStringAsync();
            return JsonConvert.DeserializeObject<List<Topic>>(content);
        }
        return null;
    }

    // További API hívások...
}

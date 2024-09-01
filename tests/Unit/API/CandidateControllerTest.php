<?php

namespace Tests\Feature\API;

use App\Models\Candidate;
use App\Models\Job;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CandidateControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @var \App\Models\User
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /** @test */
    public function it_can_list_candidates()
    {
        Candidate::factory(5)->create();

        $response = $this->getJson('/api/candidates');

        $response->assertStatus(200)
                 ->assertJsonCount(5, 'data'); 
    }


    /** @test */
    public function it_can_create_a_candidate()
    {
        $candidateData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890',
            'address' => '123 Main Street'
        ];

        $response = $this->postJson('/api/candidates', $candidateData);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'John Doe')
                 ->assertJsonPath('data.email', 'john.doe@example.com');
        
        $this->assertDatabaseHas('candidates', $candidateData);
    }

    /** @test */
    public function it_can_apply_for_jobs()
    {
        $candidate = Candidate::factory()->create();
        $jobs = Job::factory(3)->create();

        $response = $this->postJson("/api/candidates/{$candidate->id}/apply", [
            'job_ids' => $jobs->pluck('id')->toArray(),
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('message', 'Candidato inscrito nas vagas selecionadas com sucesso!');
        
        $this->assertDatabaseCount('candidate_job', 3); 
    }

    /** @test */
    public function it_can_update_a_candidate()
    {
        $candidate = Candidate::factory()->create();

        $updateData = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'phone' => '0987654321',
            'address' => '321 Main Street'
        ];

        $response = $this->putJson("/api/candidates/{$candidate->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Jane Doe')
                 ->assertJsonPath('data.email', 'jane.doe@example.com');
        
        $this->assertDatabaseHas('candidates', $updateData);
    }

    /** @test */
    public function it_can_delete_a_candidate()
    {
        $candidate = Candidate::factory()->create();

        $response = $this->deleteJson("/api/candidates/{$candidate->id}");

        $response->assertStatus(200)
                 ->assertJsonPath('message', 'Candidato excluído com sucesso!');
        
        $this->assertDatabaseMissing('candidates', ['id' => $candidate->id]);
    }

}

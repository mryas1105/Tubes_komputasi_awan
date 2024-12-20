pipeline {
    agent any
<<<<<<< HEAD

    environment {
        DISCORD_WEBHOOK_URL = 'https://discordapp.com/api/webhooks/1319572452438839307/yVvnw9jlcUMmuKh3w3tmPnDqKUP-h7rL58_ljjzQnFf92Wg7-lRrlURNH4lJb7qTJlwR' // Ganti dengan URL webhook yang kamu dapatkan
    }

    stages {
        stage('Build') {
            steps {
                script {
                    echo 'Running build...'
                }
            }
        }
        stage('Test') {
            steps {
                script {
                    echo 'Running tests...'
                }
            }
        }
    }

    post {
        success {
            script {
                def embed = [
                    title       : "Build Sukses :tada:",
                    description : "Job: ${env.JOB_NAME}\nBuild: ${env.BUILD_NUMBER}\nStatus: \`\`\`BERHASIL\`\`\`",
                    color       : 3066993
                ]
                def message = [embeds: [embed]]
                httpRequest(
                    url          : DISCORD_WEBHOOK_URL,
                    httpMode     : 'POST',
                    contentType  : 'APPLICATION_JSON',
                    requestBody  : groovy.json.JsonOutput.toJson(message)
                )
            }
        }
        failure {
            script {
                def embed = [
                    title       : "Build Gagal :x:",
                    description : "Job: ${env.JOB_NAME}\nBuild: ${env.BUILD_NUMBER}\nStatus: \`\`\`GAGAL\`\`\`",
                    color       : 15158332
                ]
                def message = [embeds: [embed]]
                httpRequest(
                    url          : DISCORD_WEBHOOK_URL,
                    httpMode     : 'POST',
                    contentType  : 'APPLICATION_JSON',
                    requestBody  : groovy.json.JsonOutput.toJson(message)
                )
=======
    stages {
        stage("hello") {
            steps {
                echo "my jenkins pipeline"
>>>>>>> 82d16f376a59ec543264e3568d29a55105ba27b0
            }
        }
    }
}

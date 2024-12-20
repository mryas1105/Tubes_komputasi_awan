pipeline {
    agent any

    environment {
        // Ganti dengan URL webhook yang kamu dapatkan
        DISCORD_WEBHOOK_URL = 'https://discordapp.com/api/webhooks/1319572452438839307/yVvnw9jlcUMmuKh3w3tmPnDqKUP-h7rL58_ljjzQnFf92Wg7-lRrlURNH4lJb7qTJlwR'
    }

    stages {
        stage('Build') {
            steps {
                script {
                    echo 'Running build...'
                    // Tambahkan langkah build yang kamu butuhkan di sini
                }
            }
        }
        stage('Test') {
            steps {
                script {
                    echo 'Running tests...'
                    // Tambahkan langkah test yang kamu butuhkan di sini
                }
            }
        }
    }

    post {
        success {
            script {
                def embed = [
                    title       : "Build Sukses :tada:",
                    description : "Job: ${env.JOB_NAME}\nBuild: ${env.BUILD_NUMBER}\nStatus: SUCCESS",
                    color       : 3066993
                ]
                def message = [embeds: [embed]]
                httpRequest(
                    url         : DISCORD_WEBHOOK_URL,
                    httpMode    : 'POST',
                    contentType : 'APPLICATION_JSON',
                    requestBody : groovy.json.JsonOutput.toJson(message)
                )
            }
        }
        failure {
            script {
                def embed = [
                    title       : "Build Gagal :x:",
                    description : "Job: ${env.JOB_NAME}\nBuild: ${env.BUILD_NUMBER}\nStatus: FAILURE",
                    color       : 15158332
                ]
                def message = [embeds: [embed]]
                httpRequest(
                    url         : DISCORD_WEBHOOK_URL,
                    httpMode    : 'POST',
                    contentType : 'APPLICATION_JSON',
                    requestBody : groovy.json.JsonOutput.toJson(message)
                )
            }
        }
    }
}

from rest_framework.decorators import api_view, permission_classes
from rest_framework.response import Response
from rest_framework import status
from rest_framework.permissions import IsAuthenticated
from .models import Art
from .serializers import ArtSerializer

@api_view(['GET', 'POST'])
@permission_classes([IsAuthenticated])
def ArtListCreateView(request):
    if request.method == 'GET':
        filter_my_arts = request.query_params.get('my_arts', 'false').lower() == 'true' 

        if filter_my_arts:
            arts = Art.objects.filter(user=request.user).order_by('-created_at') 
        else:
            arts = Art.objects.all().order_by('-created_at')

        serializer = ArtSerializer(arts, many=True, context={'request': request})
        return Response(serializer.data)

    if request.method == 'POST':
        data = request.data.copy()
        data['user'] = request.user.id  # Garante que o usuário autenticado seja o dono da arte
        print(request.FILES)  # Depuração
        if 'image' not in request.FILES:
            return Response({'error': 'Imagem não recebida'}, status=status.HTTP_400_BAD_REQUEST)

        image = request.FILES['image']
        image.name = f"{request.user.id}_{image.name}"  # Evita nomes duplicados

        art = Art(user=request.user, image=image, caption=request.data.get('caption', ''))
        art.save()  # Salva manualmente

        serializer = ArtSerializer(art, context={'request': request})  # Passa contexto
        return Response(serializer.data, status=status.HTTP_201_CREATED)
    
@api_view(['PUT', 'DELETE'])
@permission_classes([IsAuthenticated])
def ArtDetailView(request, art_id):
    try:
        art = Art.objects.get(id=art_id, user=request.user)  # Só pode editar/deletar se for do usuário
    except Art.DoesNotExist:
        return Response({'error': 'Arte não encontrada ou você não tem permissão'}, status=status.HTTP_404_NOT_FOUND)

    if request.method == 'PUT':
        serializer = ArtSerializer(art, data=request.data, partial=True, context={'request': request})
        if serializer.is_valid():
            serializer.save()
            return Response(serializer.data)
        return Response(serializer.errors, status=status.HTTP_400_BAD_REQUEST)

    if request.method == 'DELETE':
        art.delete()
        return Response({'message': 'Arte deletada com sucesso'}, status=status.HTTP_204_NO_CONTENT)